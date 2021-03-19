<?php 
namespace Bank;
    class Currency {
        private $API = 'https://api.exchangeratesapi.io/latest';
        public $T = 500;
        public $data;

        
        public function writeData($rez) {
            //$this -> data = $rez;
            file_put_contents(DIR.'/data/apiData.json', json_encode(['time' => time(), 'data' => $rez])); // $this -> data
        }
        public function getCurrency($currency) {
            $allCurr = json_decode(file_get_contents(DIR.'/data/apiData.json'));
            return $allCurr->data -> rates-> $currency;
        }
        /****************************************************************************************/
        public function oneTimeScen() {
            if(!file_exists(DIR.'/data/apiData.json')) {
                $dataFile = json_encode(['time' => time() - $T - 1, 
                                         'data' => (object)[]
                                         ]);  // <_____________________CHECK
                file_put_contents(DIR.'/data/apiData.json', $dataFile);
            }
        }
        public function currencyUpd() {
            $cache = json_decode(file_get_contents(DIR.'/data/apiData.json'));
            if(($cache -> time) < (time() - $this -> T)) {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $this -> API);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $rez = curl_exec($curl);
                curl_close($curl);
                $rez = json_decode($rez);
                $type = 'API';
                $this -> writeData($rez);
            } else {
                $type = 'CACHE';
                $rez = $cache->data;
                }
                $rezArr[0] = $rez; 
                $rezArr[1] = $type;
                return $rezArr;
        }
    }

?>