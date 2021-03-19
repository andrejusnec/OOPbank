<?php 
namespace Bank;
    class Currency {
        private $API = 'https://api.exchangeratesapi.io/latest';
        private $data;

        public function getDataFromJson() {
            $dataFile = file_get_contents(DIR.'/data/apiData.json');
            $this -> data = json_decode($dataFile); 
        }

        public function getCurrExchange() { //parsipuciu informacija ir irasau i json faila
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this -> API);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $rez = curl_exec($curl);
            $rez = json_decode($rez);
            curl_close($curl);
            $this -> writeData($rez);
        }
        public function writeData($rez) {
            if(!file_exists(DIR.'/data/apiData.json')) {
                $dataFile = json_encode([$rez]);  // $this -> data
                file_put_contents(DIR.'/data/apiData.json', $dataFile);
            } else {
            file_put_contents(DIR.'/data/apiData.json', json_encode($rez)); // $this -> data
            }
        }
        public function getCurrency($currency) {
            $this -> getDataFromJson();
            return $this->data -> rates-> $currency;
        }
        public function getData() {
            return $this -> data;
        }

    }

?>