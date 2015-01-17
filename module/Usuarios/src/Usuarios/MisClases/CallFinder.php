<?php

namespace Usuarios\MisClases;

use Zend\Db\Adapter\Adapter;

class CallFinder {

    private $sql;
    public static $instance = null;
    public $servidor;
    public $usuario;
    public $contrasenia;
    public $adapter;

    public static function getInstance($desde, $hasta, $idAgente,$servidor = "cloud") {
        
        $desde = date("Y-m-d", strtotime($desde));
        $hasta = date("Y-m-d", strtotime($hasta));
        
        if (self::$instance == null) {
            self::$instance = new CallFinder();
        }

        if ($servidor == "uruguay") {
            self::$instance->servidor = "192.168.1.19";
            self::$instance->usuario = "root";
            self::$instance->contrasenia = "feic0g";
            self::$instance->db = "vicidial";
        } else {
            self::$instance->servidor = "192.168.45.1";
            self::$instance->usuario = "root";
            self::$instance->contrasenia = "T3l3-Uy!";
            self::$instance->db = "asterisk";
        }

        self::$instance->adapter = new Adapter(array(
            'host' => self::$instance->servidor,
            'driver' => 'Mysqli',
            'database' => self::$instance->db,
            'username' => self::$instance->usuario,
            'password' => self::$instance->contrasenia,
            'charset' => 'utf8'
        ));

        $sqlUruguay = "(select distinct SQL_CALC_FOUND_ROWS rl.vicidial_id as 'ID', rl.filename, vu.full_name as 'Agent', vl.phone_number as 'Phone Number', 'uy' as db_source, vig.group_name as 'Campaign ID / Queue', vl.call_date as 'Call Date', SEC_TO_TIME(rl.length_in_sec) as Length, vl.term_reason as 'Term', ifnull((select vs.status_name from vicidial_statuses vs where vs.status = vl.status
                UNION
                select vcs.status_name from vicidial_campaign_statuses vcs where vcs.status = vl.status
                and vcs.campaign_id in(select vc.campaign_id from vicidial_campaigns vc where vc.closer_campaigns like concat('%',vl.campaign_id ,'%'))
                limit 0,1
                ), 'N/A') as Disposition
                from recording_log rl, vicidial_users vu, vicidial_list vls, vicidial_closer_log vl, vicidial_inbound_groups vig
                where vl.closecallid = rl.vicidial_id
                and vig.group_id = vl.campaign_id
                and vl.user = vu.user
                and vls.lead_id = vl.lead_id
                and rl.length_in_sec is not null
                and vl.user in('".$idAgente."')


                and vl.call_date >= '$desde 00:00:00'
                and vl.call_date <= '$hasta 23:59:59'



                )
                UNION ALL
                (select distinct  rl.vicidial_id as 'ID', rl.filename, vu.full_name as 'Agent', vl.phone_number as 'Phone Number', 'uy' as db_source, vc.campaign_name as 'Campaign ID / Queue', vl.call_date as 'Call Date', SEC_TO_TIME(rl.length_in_sec) as Length, vl.term_reason as 'Term', ifnull((select vs.status_name from vicidial_statuses vs where vs.status = vl.status
                                                        UNION
                                                        select vcs.status_name from vicidial_campaign_statuses vcs where vcs.status = vl.status
                                                        and vcs.campaign_id = vl.campaign_id
                                                        limit 0,1
                                                        ), 'N/A') as Disposition
                                from recording_log rl, vicidial_users vu, vicidial_list vls, vicidial_log vl, vicidial_campaigns vc
                                where vl.uniqueid = rl.vicidial_id
                                and vc.campaign_id = vl.campaign_id
                                and vl.user = vu.user
                                and rl.length_in_sec is not null
                                and vls.lead_id = vl.lead_id
                                 and vl.user in('".$idAgente."')


                                 and vl.call_date >= '$desde 00:00:00'
                                 and vl.call_date <= '$hasta 23:59:59'


                                )
                order by `Call Date`
                limit 0,100";
        
        $sqlCloud = "(select distinct SQL_CALC_FOUND_ROWS rl.vicidial_id as 'ID', rl.filename, vu.full_name as 'Agent', vl.phone_number as 'Phone Number', 'cloud' as db_source, vig.group_name as 'Campaign ID / Queue', vl.call_date as 'Call Date', SEC_TO_TIME(rl.length_in_sec) as Length, vl.term_reason as 'Term', ifnull((select vs.status_name from vicidial_statuses vs where vs.status = vl.status
                                    UNION
                                    select vcs.status_name from vicidial_campaign_statuses vcs where vcs.status = vl.status
                                    and vcs.campaign_id in(select vc.campaign_id from vicidial_campaigns vc where vc.closer_campaigns like concat('%',vl.campaign_id ,'%'))
                                    limit 0,1
                                    ), 'N/A') as Disposition
                       from recording_log rl, vicidial_users vu, vicidial_list vls, vicidial_closer_log vl, vicidial_inbound_groups vig
                       where vl.closecallid = rl.vicidial_id
                       and vig.group_id = vl.campaign_id
                       and vl.user = vu.user
                       and vls.lead_id = vl.lead_id
                       and rl.length_in_sec is not null
                        and vl.user in('".$idAgente."')
                       
                       
                        and vl.call_date >= '$desde 00:00:00'
                        and vl.call_date <= '$hasta 23:59:59'
                       
                       
                       
                       )
                UNION ALL
                (select distinct  rl.vicidial_id as 'ID', rl.filename, vu.full_name as 'Agent', vl.phone_number as 'Phone Number', 'cloud' as db_source, vc.campaign_name as 'Campaign ID / Queue', vl.call_date as 'Call Date', SEC_TO_TIME(rl.length_in_sec) as Length, vl.term_reason as 'Term', ifnull((select vs.status_name from vicidial_statuses vs where vs.status = vl.status
                                    UNION
                                    select vcs.status_name from vicidial_campaign_statuses vcs where vcs.status = vl.status
                                    and vcs.campaign_id = vl.campaign_id
                                    limit 0,1
                                    ), 'N/A') as Disposition
                        from recording_log rl, vicidial_users vu, vicidial_list vls, vicidial_log vl, vicidial_campaigns vc
                        where vl.uniqueid = rl.vicidial_id
                        and vc.campaign_id = vl.campaign_id
                        and vl.user = vu.user
                        and rl.length_in_sec is not null
                        and vls.lead_id = vl.lead_id
                         and vl.user in('".$idAgente."')
                        
                        
                         and vl.call_date >= '$desde 00:00:00'
                         and vl.call_date <= '$hasta 23:59:59'
                        
                        
                        )
                order by `Call Date`
                      limit 0,100";
        
        if($servidor == "uruguay"){
            $sql = $sqlUruguay;
        }else{
            $sql = $sqlCloud;
        }
        
        self::$instance->sql = $sql;
        
        return self::$instance;
    }

    private function __construct() {}

    public function run() {

        $res = $this->adapter->query($this->sql);

        $objs = array();

        if ($res) {
            $result = $res->execute();

            foreach ($result as $item) {
                $objs[] = $item;
                //$this->getRecord($item);
            }
        } else {
            return false;
        }

        return $objs;
    }

    

}
