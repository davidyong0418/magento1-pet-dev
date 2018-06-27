<?php
class Addedbytes_Storelocator_Block_View extends Mage_Core_Block_Template
{

    protected function _prepareLayout()
    {
        // Only run this with the Store Locator
        if (Mage::app()->getRequest()->getControllerModule() != 'Addedbytes_Storelocator') {
            return false;
        }

        // Work out if there is anything to add to the head as a title
        $addToHead = false;
        $storeLocatorText = Mage::getStoreConfig('storelocator/display_options/storelocator_toplink_text');
        if ($this->getRequest()->getActionName() == 'store') {
            $addToHead = $this->getCurrentStore()->getStoreName() . ' - ' . $storeLocatorText . ' - ';
        } elseif ($this->getRequest()->getActionName() == 'locator') {
            $addToHead = 'Your Nearest Store - ' . $storeLocatorText . ' - ';
        } elseif ($this->getRequest()->getActionName() == 'index') {
            $addToHead = $storeLocatorText . ' - ';
        }
        if ($head = $this->getLayout()->getBlock('head')) {
            if (substr($head->getTitle(), 0, strlen($addToHead)) <> $addToHead) {
                $head->setTitle($addToHead . $head->getTitle());
            }
        }

        parent::_prepareLayout();
    }

    public function hasStores()
    {
        return $this->getStoreCollection()->getSize() > 0;
    }

    public function getStoreCollection($pageSize = null)
    {
        if (!$this->_storeCollection || (intval($pageSize) > 0
            && $this->_storeCollection->getSize() != intval($pageSize))
        ) {
            $this->_storeCollection = Mage::getModel('addedbytesstorelocator/store')
                ->getCollection()
                ->setOrder('store_name', 'ASC')
                ->addIsActiveFilter()
                ->addStoreFilter(Mage::app()->getStore()->getId());

            if (isset($pageSize) && intval($pageSize) && intval($pageSize) > 0) {
                $this->_storeCollection->setPageSize(intval($pageSize));
            }
        }

        return $this->_storeCollection;
    }

    /**
     * Fetch current store if set
     */
    public function getCurrentStore()
    {
        if (!$this->hasData('current_store')) {
            $this->setData('current_store', Mage::registry('current_store'));
        }

        return $this->getData('current_store');
    }

    /**
     * Fetch nearest stores, using Google maps geocode to look up address coordinates
     */
    public function getNearestStore()
    {

        // For use on presentation side
        Mage::register('postcode', $_REQUEST['postcode']);

        $geocode_url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_REQUEST['postcode']) . '&sensor=false';

        // Try to collect file from Google
        try {
            $curl = curl_init($geocode_url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
            $geocode_raw = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            if (Mage::getIsDeveloperMode()) {
                throw new Exception($e->getMessage());
            } else {
                Mage::helper('addedbytes/log')->addEntry($e->getMessage(), Zend_Log::ERR);

                return false;
            }
        }

        // Check for response
        if (!$geocode_raw) {
            return false;
        }

        // JSON decode response
        $geocode_data = json_decode($geocode_raw);

        // Check we have results
        if (!$geocode_data->results) {
            return false;
        }

        // For use on presentation side
        Mage::register('geocode_results', $geocode_data->results);

        $userCoordinates = array(
            'latitude' => $geocode_data->results[0]->geometry->location->lat,
            'longitude' => $geocode_data->results[0]->geometry->location->lng
        );
        Mage::register('usercoordinates', $userCoordinates);

        $stores_by_distance = array();
        $nearest_store = array(
            'distance' => 9999999999,
            'store' => false
        );
        foreach ($this->getStoreCollection() as $_store) {
            $store = array();
            $store['id'] = $_store->getStoreId();
            $store['latitude'] = $_store->getStoreLatitude();
            $store['longitude'] = $_store->getStoreLongitude();

            if ((is_numeric($store['latitude'])) && (is_numeric($store['longitude']))) {
                // Calculate distance
                $distance = Mage::helper('addedbytes_storelocator')->getDistance($userCoordinates, $store);
                $store['km'] = $distance;
                $store['miles'] = Mage::helper('addedbytes_storelocator')->convertKmToMiles($distance);
                $stores_by_distance[($distance * 10000)] = $store; // Multiply by 10000 as floats as keys are funky and we get collisions
            }

            // Set neasest store
            if ($distance < $nearest_store['distance']) {
                $nearest_store['distance'] = $distance;
                $nearest_store['store'] = $_store;
            }
        }

        if (count($stores_by_distance) == 0) {
            //return false;
        }

        // Sort by distance, closest first
        ksort($stores_by_distance);
        $stores_by_distance = array_values($stores_by_distance);

        // Register nearest store for directions
        Mage::register('current_store', $nearest_store['store']);

        return $stores_by_distance;
    }

    /**
     * Radius to search within. If there's a store within 50km, only
     * search within 50km. Otherwise, cast a wider net.
     */
    public function getUpperLimit($number)
    {
        if ($number < 50) {
            return 50;
        } else {
            return 100;
        }

        return $number;
    }

    /**
     * Fetch stores to display on map. If there's a current store, just
     * show that. If not, show the collection.
     */
    public function getMapStores()
    {
        $_store  = $this->getCurrentStore();
        $mapStores = array();
        if ($_store) {
            $mapStores[] = $_store;
        } else {
            $_collection = $this->getStoreCollection();
            foreach ($_collection as $storeItem) {
                $mapStores[] = $storeItem;
            }
        }

        return $mapStores;
    }
}
