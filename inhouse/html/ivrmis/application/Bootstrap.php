<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        $theme = 'default';
        if (isset($this->config->app->theme)) {
            $theme = $this->config->app->theme;
        }
        $path = PUBLIC_PATH.'themes/'.$theme;

        $layout = Zend_Layout::startMvc()
            ->setLayout('layout')
            ->setLayoutPath($path)
            ->setContentKey('content');

        $view = new Zend_View();
        $view->setBasePath($path);
        $view->setScriptPath($path);

        // setting media path for css/js/images
        $mediapath = explode('/www/html',$path);
        $mediapath = $mediapath[1];
        define('MEDIA_PATH',$mediapath);

           define('PORTLET_MEDIA_PATH','http://'.$_SERVER['SERVER_ADDR'].'/'.$mediapath);
           define('MIS_circlepulses','http://192.168.4.41:8081/IVRReport1/CircleTotalPulses');
           define('MIS_circlecalls','http://192.168.4.41:8081/IVRReport1/CircleTotalCalls');
           define('MIS_circleduration','http://192.168.4.41:8081/IVRReport1/CircleTotalDuration');
           define('MIS_serviceduration','http://192.168.4.41:8081/IVRReport1/ServiceTotalDuration');
           define('MIS_servicecalls','http://192.168.4.41:8081/IVRReport1/ServiceTotalCalls'); 
           define('MIS_servicepulses','http://192.168.4.41:8081/IVRReport1/ServiceTotalPulses');
           define('MIS_categorytime','http://192.168.4.41:8081/IVRReport1/CategoryPlayTime');
           define('MIS_categorysong','http://192.168.4.41:8081/IVRReport1/CategoryPlayCount');
           define('MIS_categorycount','http://192.168.4.41:8081/IVRReport1/CategoryPlaySongs');
          // define('MIS_categorycount','http://192.168.4.41:8081/IVRReport1/CategoryPlaySongs');
           define('MIS_shortcodetime','http://192.168.4.41:8081/IVRReport1/ShortCodePlayTime');
           define('MIS_shortcodecount','http://192.168.4.41:8081/IVRReport1/ShortCodePlayCount');
           define('MIS_shortcodesong','http://192.168.4.41:8081/IVRReport1/ShortCodePlayedSong');
           define('MIS_ringtonehits','http://192.168.4.41:8081/IVRReport1/RingToneHits');
           define('MIS_timecalls','http://192.168.4.41:8081/IVRReport1/IntervalTotalCalls');
           define('MIS_timepulses','http://192.168.4.41:8081/IVRReport1/IntervalTotalPulses');
           define('MIS_timeduration','http://192.168.4.41:8081/IVRReport1/IntervalTotalDuration');
           define('MIS_albumtime','http://192.168.4.41:8081/IVRReport1/AlbumPlayTime');
           define('MIS_albumcount','http://192.168.4.41:8081/IVRReport1/AlbumPlayCount');
           define('MIS_albumsongs','http://192.168.4.41:8081/IVRReport1/AlbumPlayedSongs');
           define('MIS_msisdnchart','http://192.168.4.41:8081/IVRReport1/CircleWiseSummary');
           define('MIS_servicechart','http://192.168.4.41:8081/IVRReport1/MsisdnSummary');
           define('MIS_circledetail','http://192.168.4.41:8081/IVRReport1/CircleWiseDetailedReport');
           define('MIS_servicedetail','http://192.168.4.41:8081/IVRReport1/ServiceWiseDetailedReport');
           define('MIS_msisdn','http://192.168.4.41:8081/ReportGeneration/FillData');
             define('MIS_service','http://192.168.4.41:8081/ReportGeneration/FillData');
                 define('MIS_short','http://192.168.4.41:8081/ReportGeneration/FillData');
                     define('MIS_time','http://192.168.4.41:8081/ReportGeneration/FillData');
                       define('MIS_timesummary','http://192.168.4.41:8081/IVRReport1/TimeBased');
                     define('MIS_ringtonesummary','http://192.168.4.41:8081/IVRReport1/RingtoneSummary');
                      define('MIS_rintonedetail','http://192.168.4.41:8081/IVRReport1/RingtoneDetail');
                       define('MIS_categorysummary','http://192.168.4.41:8081/IVRReport1/CategorySummary');
                      define('MIS_categorydetail','http://192.168.4.41:8081/IVRReport1/CategoryDetailReport');
                       define('MIS_shortcodesumm','http://192.168.4.41:8081/IVRReport1/ShortCodeSummary');
                      define('MIS_shortcodedetail','http://192.168.4.41:8081/IVRReport1/ShortCodeDetailReport');
                     define('MIS_albsummary','http://192.168.4.41:8081/IVRReport1/AlbumSummary');
                      define('MIS_albdetail','http://192.168.4.41:8081/IVRReport1/AlbumDetailedReport');
                      define('MIS_chpass','http://192.168.4.41:8081/IVRReport1/ChangePassword');
                       define('MIS_createnewuser','http://192.168.4.41:8081/IVRReport1/RegisterUser');
                      define('MIS_updateuser','http://192.168.4.41:8081/IVRReport1/UpdateUser');
                      define('MIS_login','http://192.168.4.41:8081/IVRReport1/UserLogin');
                     
                      return $view;
    }

}

