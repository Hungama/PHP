<?php

/**
 * Class for portal builder model
 *
 * This class is used for portal builder model 
 *
 * @version 1.0
 * @project GDP
 */
class Application_Model_Index extends Application_Model_Gdplibrary {

    public function __construct(array $options = null) {
        
    }

    private $PORTLETS_WHDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_PortletService?wsdl';
    private $USER_PORTLETS_WHDL = 'http://192.168.4.43:8080/PortletInfo-portlet/axis/Plugin_PortletInfo_PortletInfoService?wsdl';
    private $RESOLUTION_WSDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_ResolutionService?wsdl';
    private $CONTAINER_WSDL_URI = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_ContainerService?wsdl';
    private $LAYOUT_WSDL_URI = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_LayoutService?wsdl';
    private $PAGE_WSDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_PageService?wsdl';
    private $SECTION_WSDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_SectionService?wsdl';
    private $PORTLETS_WSDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_PortletService?wsdl';
    private $LAYOUT_PORTLET_WSDL = 'http://192.168.4.43:8080/PortalBuilder-portlet/axis/Plugin_PortalBuilder_LayoutPortletService?wsdl';

    /**
     * allPortletEntries function
     *
     * This function is used to get all portlet enteries
     *
     * @see
     * @return
     */
    public function allPortletEntries() {
        try {
            $client = new SoapClient($this->PORTLETS_WHDL);
            $res = $client->getAllPortlet();
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * userPortletEntries function
     *
     * This function is used to get all portlet enteries selected by user
     *
     * @see
     * @return
     */
    public function userPortletEntries() {
        try {
            $client = new SoapClient($this->USER_PORTLETS_WHDL);
            $res = $client->getUserPortlet(array('userid' => $_SESSION['User']['id']));
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * getResolutions function
     *
     * This function is used to get all resolutions
     *
     * @see
     * @return
     */
    public function getResolutions() {
        try {
            $client = new SoapClient($this->RESOLUTION_WSDL);
            $res = $client->findAllActiveResolution();
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * allcontainer function
     *
     * This function is used to add container
     *
     * @see
     * @return
     */
    public function addContainer($data) {
        try {
            $client = new Zend_Soap_Client($this->CONTAINER_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'createContainer';
            $result = $client->createContainer(
                    $this->toXml(
                        array(
                            'backgroundColor' => $data['backgroundColor'],
                            'borderBottom' => $data['borderBottom'],
                            'borderBottomColor' => $data['borderBottomColor'],
                            'borderBottomStyle' => $data['borderBottomStyle'],
                            'borderBottomUnit ' => $data['borderBottomUnit'],
                            'borderLeft' => $data['borderLeft'],
                            'borderLeftColor' => $data['borderLeftColor'],
                            'borderLeftStyle' => $data['borderLeftStyle'],
                            'borderLeftUnit' => $data['borderLeftUnit'],
                            'borderRight' => $data['borderRight'],
                            'borderRightColor' => $data['borderRightColor'],
                            'borderRightStyle' => $data['borderRightStyle'],
                            'borderRightUnit' => $data['borderRightUnit'],
                            'borderTop' => $data['borderTop'],
                            'borderTopColor' => $data['borderTopColor'],
                            'borderTopStyle' => $data['borderTopStyle'],
                            'borderTopUnit' => $data['borderTopUnit'],
                            'bottomMargin' => $data['bottomMargin'],
                            'bottomMarginUnit' => $data['bottomMarginUnit'],
                            'bottomPadding' => $data['bottomPadding'],
                            'bottomPaddingUnit' => $data['bottomPaddingUnit'],
                            'containerHeight' => $data['containerHeight'],
                            'containerId' => $data['containerId'],
                            'containerName' => $data['containerName'],
                            'containerWidth' => $data['containerWidth'],
                            'containerXaxis' => $data['containerXaxis'],
                            'containerYaxis' => $data['containerYaxis'],
                            'css' => $data['css'],
                            'font' => $data['font'],
                            'fontAlignment' => $data['fontAlignment'],
                            'fontColor' => $data['fontColor'],
                            'fontSize' => $data['fontSize'],
                            'isActive' => true,
                            'isBold' => $data['isBold'],
                            'isBorderColorSameForAll' => $data['isBorderColorSameForAll'],
                            'isBorderStyleSameForAll' => $data['isBorderStyleSameForAll'],
                            'isBorderWidthSameForAll' => $data['isBorderWidthSameForAll'],
                            'isItalic' => $data['isItalic'],
                            'isMargineSameForAll' => $data['isMargineSameForAll'],
                            'isPaddingSameForAll' => $data['isPaddingSameForAll'],
                            'leftMargin' => $data['leftMargin'],
                            'leftMarginUnit' => $data['leftMarginUnit'],
                            'leftPadding' => $data['leftPadding'],
                            'leftPaddingUnit' => $data['leftPaddingUnit'],
                            'letterSpacing' => $data['letterSpacing'],
                            'lineHeight' => $data['lineHeight'],
                            'primaryKey' => 0,
                            'rightMargin' => $data['rightMargin'],
                            'rightMarginUnit' => $data['rightMarginUnit'],
                            'rightPadding' => $data['rightPadding'],
                            'rightPaddingUnit' => $data['rightPaddingUnit'],
                            'textDecoration' => $data['textDecoration'],
                            'topMargin' => $data['topMargin'],
                            'topMarginUnit' => $data['topMarginUnit'],
                            'topPadding' => $data['topPadding'],
                            'topPaddingUnit' => $data['topPaddingUnit'],
                            'updatedby' => $_SESSION['Username'],
                            'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z',
                            'wordSpacing' => $data['wordSpacing'],
                        )
                      ,$rootNodeName = 'AddContainer')
                    );
            return $result;
        } catch (Exception $e) {
            // print_r($e);
        }
    }
    
    /**
     * updateContainer function
     *
     * This function is used to update container
     *
     * @see
     * @return
     */
    public function updateContainer($data) {
        try {
            $client = new Zend_Soap_Client($this->CONTAINER_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            print_r($data); 
            $client->setOptions($options);
            $client->action = 'updateContainer';
            $result = $client->updateContainer(array(
                        'backgroundColor' => $data['backgroundColor'],
                        'borderBottom' => $data['borderBottom'],
                        'borderBottomColor' => $data['borderBottomColor'],
                        'borderBottomStyle' => $data['borderBottomStyle'],
                        'borderBottomUnit ' => $data['borderBottomUnit'],
                        'borderLeft' => $data['borderLeft'],
                        'borderLeftColor' => $data['borderLeftColor'],
                        'borderLeftStyle' => $data['borderLeftStyle'],
                        'borderLeftUnit' => $data['borderLeftUnit'],
                        'borderRight' => $data['borderRight'],
                        'borderRightColor' => $data['borderRightColor'],
                        'borderRightStyle' => $data['borderRightStyle'],
                        'borderRightUnit' => $data['borderRightUnit'],
                        'borderTop' => $data['borderTop'],
                        'borderTopColor' => $data['borderTopColor'],
                        'borderTopStyle' => $data['borderTopStyle'],
                        'borderTopUnit' => $data['borderTopUnit'],
                        'bottomMargin' => $data['bottomMargin'],
                        'bottomMarginUnit' => $data['bottomMarginUnit'],
                        'bottomPadding' => $data['bottomPadding'],
                        'bottomPaddingUnit' => $data['bottomPaddingUnit'],
                        'containerHeight' => $data['containerHeight'],
                        'containerId' => $data['containerId'],
                        'containerName' => $data['containerName'],
                        'containerWidth' => $data['containerWidth'],
                        'containerXaxis' => $data['containerXaxis'],
                        'containerYaxis' => $data['containerYaxis'],
                        'css' => $data['css'],
                        'font' => $data['font'],
                        'fontAlignment' => $data['fontAlignment'],
                        'fontColor' => $data['fontColor'],
                        'fontSize' => $data['fontSize'],
                        'isActive' => true,
                        'isBold' => $data['isBold'],
                        'isBorderColorSameForAll' => $data['isBorderColorSameForAll'],
                        'isBorderStyleSameForAll' => $data['isBorderStyleSameForAll'],
                        'isBorderWidthSameForAll' => $data['isBorderWidthSameForAll'],
                        'isItalic' => $data['isItalic'],
                        'isMargineSameForAll' => $data['isMargineSameForAll'],
                        'isPaddingSameForAll' => $data['isPaddingSameForAll'],
                        'leftMargin' => $data['leftMargin'],
                        'leftMarginUnit' => $data['leftMarginUnit'],
                        'leftPadding' => $data['leftPadding'],
                        'leftPaddingUnit' => $data['leftPaddingUnit'],
                        'letterSpacing' => $data['letterSpacing'],
                        'lineHeight' => $data['lineHeight'],
                        'primaryKey' => $data['containerId'],
                        'rightMargin' => $data['rightMargin'],
                        'rightMarginUnit' => $data['rightMarginUnit'],
                        'rightPadding' => $data['rightPadding'],
                        'rightPaddingUnit' => $data['rightPaddingUnit'],
                        'textDecoration' => $data['textDecoration'],
                        'topMargin' => $data['topMargin'],
                        'topMarginUnit' => $data['topMarginUnit'],
                        'topPadding' => $data['topPadding'],
                        'topPaddingUnit' => $data['topPaddingUnit'],
                        'updatedby' => $_SESSION['Username'],
                        'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z',
                        'wordSpacing' => $data['wordSpacing'],
                        'containerId' => $data['containerId'],
                    ));
            return $result;
        } catch (Exception $e) {
            // print_r($e);
        }
    }

    /**
     * getContainerById function
     *
     * This function is used to get container by id
     *
     * @see
     * @return
     */
    public function getContainerById($id) {
        try {
            $client = new Zend_Soap_Client($this->CONTAINER_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findByContainerId';
            $result = $client->findByContainerId($id);
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * getPortletById function
     *
     * This function is used to get portlet by id
     *
     * @see
     * @return
     */
    public function getPortletById($id) {
        try {
            $client = new Zend_Soap_Client($this->PORTLETS_WSDL);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findByPortletId';
            $result = $client->findByPortletId($id);
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * getContainerPortletById function
     *
     * This function is used to get container assigned portlet
     *
     * @see
     * @return
     */
    public function getContainerPortletById($id) {
        try {
            $client = new Zend_Soap_Client($this->LAYOUT_PORTLET_WSDL);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findByContainerId';
            $result = $client->findByContainerId($id);
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * addlayout function
     *
     * This function is used to add layout
     *
     * @see
     * @return
     */
    public function addLayout($data) {
        try {
            $client = new Zend_Soap_Client($this->LAYOUT_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'createLayout';
            $result = $client->createLayout(
                    $this->toXml(
                            array(
                                'containerIds' => $data['containers'],
                                'isActive' => true,
                                'layoutId' => 0,
                                'layoutName' => '',
                                'pageId' => $data['pageId'],
                                'primaryKey' => 0,
                                'updatedBy' => $_SESSION['Username'],
                                'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z'
                                ),$rootNodeName = 'AddLayout')
                    );
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * addlayout function
     *
     * This function is used to add layout
     *
     * @see
     * @return
     */
    public function updateLayout($data) {
        try {
            $client = new Zend_Soap_Client($this->LAYOUT_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'updateLayout';
            $result = $client->updateLayout(array(
                        'containerIds' => $data['containers'],
                        'isActive' => true,
                        'layoutName' => '',
                        'pageId' => $data['pageId'],
                        'layoutId' => $data['layoutId'],
                        'primaryKey' => $data['layoutId'],
                        'updatedBy' => $_SESSION['Username'],
                        'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z'
                    ));

            //echo date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
            $result;
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }
    
    /**
     * getLayoutList function
     *
     * This function is used to get layout list
     *
     * @see
     * @return
     */
    public function getLayoutList() {
        try {
            $client = new Zend_Soap_Client($this->LAYOUT_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findAllActiveLayout';
            $result = $client->findAllActiveLayout();
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * getLayoutById function
     *
     * This function is used to get layout by id
     *
     * @see
     * @return
     */
    public function getLayoutById($id) {
        try {
            $client = new Zend_Soap_Client($this->LAYOUT_WSDL_URI);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findByLayoutId';
            $result = $client->findByLayoutId($id);
            return $result;
        } catch (Exception $e) {
            //return false;
        }
    }

    

    /**
     * getPage function
     *
     * This function is used to get page entry
     *
     * @see
     * @return
     */
    public function getPage() {
        try {
            $client = new SoapClient($this->PAGE_WSDL);
            $res = $client->findAllPage();
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * getSection function
     *
     * This function is used to get section entries
     *
     * @see
     * @return
     */
    public function getSection() {
        try {
            $client = new SoapClient($this->SECTION_WSDL);
            $res = $client->findAllActiveSection();
            return $res;
            //print_r($res);
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * createSection function
     *
     * This function is used to create sections
     *
     * @see
     * @return
     */
    public function createSection($sectionName) {
        try {
            //$client = new Zend_Soap_Client($this->SECTION_WSDL);
            $client = new SoapClient($this->SECTION_WSDL,
                            array('soap_version' => SOAP_1_1,
                                'encoding' => 'ISO-8859-1',
                                'cache_wsdl' => WSDL_CACHE_NONE,
                                'trace' => 1
                    ));
            $result = $client->createSection(
                    $this->toXml(
                            array(
                                'companyId' => 0, 
                                'isActive' => true, 
                                'primaryKey' => 0, 
                                'sectionId' => 0, 
                                'sectionName' => $sectionName, 
                                'updatedby' => $_SESSION['Username'], 
                                'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z')
                            , $rootNodeName = 'CreateSection')
                    );
            return $result;
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * createPagefunction
     *
     * This function is used to create Page
     *
     * @see
     * @return
     */
    public function createPage($pageName, $section_id) {
        $client = new Zend_Soap_Client($this->PAGE_WSDL);
        $options = array('soap_version' => SOAP_1_1,
            'encoding' => 'ISO-8859-1',
        );
        $client->setOptions($options);
        $result = 0;
        try {
            $client->action = 'createPage';
            $result = $client->createPage(
                    $this->toXml(
                            array(
                                'isActive' => true,
                                'layoutId' => 0,
                                'pageId' => 0,
                                'pageName' => $pageName,
                                'primaryKey' => 0, 
                                'resolutionId' => 0, 
                                'sectionId' => $section_id,
                                'updatedby' => $_SESSION['Username'], 
                                'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z'),
                            $rootNodeName = 'CreatePage')
                    );
            return $result;
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * updatePagefunction
     *
     * This function is used to update Page
     *
     * @see
     * @return
     */
    public function updatePage($data) {
        $client = new Zend_Soap_Client($this->PAGE_WSDL);
        $options = array('soap_version' => SOAP_1_1,
            'encoding' => 'ISO-8859-1',
        );
        $client->setOptions($options);
        $result = 0;
        try {
            $client->action = 'updatePage';
            $result = $client->updatePage(array(
                'isActive' => true, 
                'layoutId' => $data['layoutId'], 
                'pageId' => $data['pageId'], 
                'pageName' => $data['pageName'], 
                'primaryKey' => $data['pageId'], 
                'resolutionId' => $data['resolutionId'], 
                'sectionId' => $data['sectionId'], 
                'updatedby' => $_SESSION['Username'], 
                'updatedt' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z')
                    );
            return $result;
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * mapPage function
     *
     * This function is used to map portlets to layouts and containers
     *
     * @see
     * @return
     */
    public function mapPage($selectedLayoutId) {
        try {
            $client = new SoapClient($this->LAYOUT_WSDL_URI);
            $res = $client->findByLayoutId($selectedLayoutId);
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * getPortlets function
     *
     * This function is used to get portlets
     *
     * @see
     * @return
     */
    public function getPortlets() {
        try {
            $client = new SoapClient($this->PORTLETS_WSDL);
            $res = $client->findAllActivePortlets();
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * saveLayout function
     *
     * This function is used to map container to portlet
     *
     * @see
     * @return
     */
    public function saveLayout($selectedLayoutId, $selectedContainerIds, $mappedPortlets, $mappedContentTypes, $mappedRules) {
        try {

            $j = 0;
            foreach ($selectedContainerIds as $onlyone) {
                $client = new SoapClient($this->LAYOUT_PORTLET_WSDL);
                $res = $client->createLayoutPortlet(
                        $this->toXml(  
                            array(
                                'companyId' => 0,
                                'containerId' => $onlyone,
                                'createdBy' => $_SESSION['Username'],
                                'createdDate' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z',
                                'isActive' => true,
                                'layoutId' => $selectedLayoutId,
                                'layoutPortletId' => 0,
                                'modifiedDate' => date('Y-m-d') . 'T' . date('H:i:s') . 'Z',
                                'portletId' => $mappedPortlets[$j++],
                                'contentTypeId' => $mappedContentTypes[$j++],
                                'ruleId' => $mappedRules[$j++],
                                'primaryKey' => 0
                            ),
                        $rootNodeName = 'SaveLayout')
                       );
                //return $res;
            }
            return 'SUCCESS';
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }

    /**
     * checkSection function
     *
     * This function is used to check already created section
     *
     * @see
     * @return
     */
    public function checkSection($sectionName) {
        try {
            $client = new Zend_Soap_Client($this->SECTION_WSDL);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findBySectioName';
            $result = $client->findBySectioName($sectionName);
            if ($result == null) {
                return $result;
            } else {
                foreach ($result as $onlyone) {
                    $response = $onlyone->sectionId;
                }
                return $response;
            }
        } catch (Exception $e) {
            //return false;
        }
    }

    /**
     * checkPage function
     *
     * This function is used to check already created page
     *
     * @see
     * @return
     */
    public function checkPage($pageName) {
        try {
            $client = new Zend_Soap_Client($this->PAGE_WSDL);
            $options = array('soap_version' => SOAP_1_1,
                'encoding' => 'ISO-8859-1',
            );
            $client->setOptions($options);
            $client->action = 'findByPageName';
            $result = $client->findByPageName($pageName);
            if ($result == null) {
                return $result;
            } else {
                foreach ($result as $onlyone) {
                    $response = $onlyone->pageId."#".$onlyone->layoutId;
                }
                return $response;
            }
        } catch (Exception $e) {
            //return false;
        }
    }
    
    public function deleteOldMapping($layoutId)
    {
        try {
            $client = new SoapClient($this->LAYOUT_PORTLET_WSDL);
            $res = $client->deleteByLayoutId($layoutId);
           print_r($res);echo "<hr />";
            return $res;
        } catch (Zend_Exception $e) {
            var_dump($e);
        }
    }
    


}
