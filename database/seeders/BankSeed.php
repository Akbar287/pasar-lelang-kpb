<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cek = Bank::count();

        if ($cek == 0) {
            $temp = [
                [
                    "kode_bank" => "014",
                    "nama_bank" => "Bank BCA",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "008",
                    "nama_bank" => "Bank Mandiri",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "009",
                    "nama_bank" => "Bank BNI",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "427",
                    "nama_bank" => "Bank BNI Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "002",
                    "nama_bank" => "Bank BRI",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "451",
                    "nama_bank" => "Bank Syariah Mandiri",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "022",
                    "nama_bank" => "Bank CIMB Niaga",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "022",
                    "nama_bank" => "Bank CIMB Niaga Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "147",
                    "nama_bank" => "Bank Muamalat",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "213",
                    "nama_bank" => "Bank Tabungan Pensiunan Nasional (BTPN)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "422",
                    "nama_bank" => "Bank BRI Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "200",
                    "nama_bank" => "Bank Tabungan Negara (BTN)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "013",
                    "nama_bank" => "Permata Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "011",
                    "nama_bank" => "Bank Danamon",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "016",
                    "nama_bank" => "Bank BII Maybank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "426",
                    "nama_bank" => "Bank Mega",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "153",
                    "nama_bank" => "Bank Sinarmas",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "950",
                    "nama_bank" => "Bank Commonwealth",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "028",
                    "nama_bank" => "Bank OCBC NISP",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "441",
                    "nama_bank" => "Bank Bukopin",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "536",
                    "nama_bank" => "Bank BCA Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "026",
                    "nama_bank" => "Bank Lippo",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "031",
                    "nama_bank" => "Citibank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "110",
                    "nama_bank" => "Bank Jabar dan Banten (BJB)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "111",
                    "nama_bank" => "Bank DKI",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "113",
                    "nama_bank" => "Bank Jateng",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "114",
                    "nama_bank" => "Bank Jatim",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "117",
                    "nama_bank" => "Bank Sumut",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "118",
                    "nama_bank" => "Bank Nagari",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "119",
                    "nama_bank" => "Bank Riau",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "120",
                    "nama_bank" => "Bank Sumsel Babel",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "121",
                    "nama_bank" => "Bank Lampung",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "122",
                    "nama_bank" => "Bank Kalsel",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "123",
                    "nama_bank" => "Bank Kalimantan Barat",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "124",
                    "nama_bank" => "Bank Kalimantan Timur dan Utara",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "125",
                    "nama_bank" => "Bank Kalteng",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "126",
                    "nama_bank" => "Bank Sulsel dan Barat",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "127",
                    "nama_bank" => "Bank Sulut Gorontalo",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "128",
                    "nama_bank" => "Bank NTB, NTB Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "130",
                    "nama_bank" => "Bank NTT",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "131",
                    "nama_bank" => "Bank Maluku Malut",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "132",
                    "nama_bank" => "Bank Papua",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "133",
                    "nama_bank" => "Bank Bengkulu",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "134",
                    "nama_bank" => "Bank Sulawesi Tengah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "135",
                    "nama_bank" => "Bank Sultra",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "003",
                    "nama_bank" => "Bank Ekspor Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "019",
                    "nama_bank" => "Bank Panin",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "020",
                    "nama_bank" => "Bank Arta Niaga Kencana",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "023",
                    "nama_bank" => "Bank UOB Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "030",
                    "nama_bank" => "American Express Bank LTD",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "031",
                    "nama_bank" => "Citibank N.A",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "032",
                    "nama_bank" => "JP. Morgan Chase Bank, N.A",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "033",
                    "nama_bank" => "Bank of America, N.A",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "034",
                    "nama_bank" => "ING Indonesia Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "037",
                    "nama_bank" => "Bank Artha Graha Internasional",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "039",
                    "nama_bank" => "Bank Credit Agricole Indosuez",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "040",
                    "nama_bank" => "The Bangkok Bank Comp. LTD",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "041",
                    "nama_bank" => "The Hongkong & Shanghai B.C. (Bank HSBC)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "042",
                    "nama_bank" => "The Bank of Tokyo Mitsubishi UFJ LTD",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "045",
                    "nama_bank" => "Bank Sumitomo Mitsui Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "046",
                    "nama_bank" => "Bank DBS Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "047",
                    "nama_bank" => "Bank Resona Perdania",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "048",
                    "nama_bank" => "Bank Mizuho Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "050",
                    "nama_bank" => "Standard Chartered Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "052",
                    "nama_bank" => "Bank ABN Amro",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "053",
                    "nama_bank" => "Bank Keppel Tatlee Buana",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "054",
                    "nama_bank" => "Bank Capital Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "057",
                    "nama_bank" => "Bank BNP Paribas Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "023",
                    "nama_bank" => "Bank UOB Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "059",
                    "nama_bank" => "Korea Exchange Bank Danamon",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "425",
                    "nama_bank" => "Bank BJB Syariah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "061",
                    "nama_bank" => "Bank ANZ Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "067",
                    "nama_bank" => "Deutsche Bank AG.",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "068",
                    "nama_bank" => "Bank Woori Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "069",
                    "nama_bank" => "Bank of China",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "076",
                    "nama_bank" => "Bank Bumi Arta",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "097",
                    "nama_bank" => "Bank Ekonomi",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "088",
                    "nama_bank" => "Bank Antardaerah",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "089",
                    "nama_bank" => "Bank Haga",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "093",
                    "nama_bank" => "Bank IFI",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "095",
                    "nama_bank" => "Bank JTRUST",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "097",
                    "nama_bank" => "Bank Mayapada",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "145",
                    "nama_bank" => "Bank Nusantara Parahyangan",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "146",
                    "nama_bank" => "Bank of India Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "151",
                    "nama_bank" => "Bank Mestika Dharma",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "152",
                    "nama_bank" => "Bank Metro Express (Bank Shinhan Indonesia)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "157",
                    "nama_bank" => "Bank Maspion Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "159",
                    "nama_bank" => "Bank Hagakita",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "161",
                    "nama_bank" => "Bank Ganesha",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "162",
                    "nama_bank" => "Bank Windu Kentjana",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "161",
                    "nama_bank" => "Halim Indonesia Bank (Bank ICBC Indonesia)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "166",
                    "nama_bank" => "Bank Harmoni International",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "167",
                    "nama_bank" => "Bank QNB Kesawan (Bank QNB Indonesia)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "212",
                    "nama_bank" => "Bank Himpunan Saudara 1906",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "405",
                    "nama_bank" => "Bank Swaguna",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "427",
                    "nama_bank" => "Bank Jasa Jakarta",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "459",
                    "nama_bank" => "Bank Bisnis Internasional",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "466",
                    "nama_bank" => "Bank Sri Partha",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "472",
                    "nama_bank" => "Bank Jasa Jakarta",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "484",
                    "nama_bank" => "Bank Bintang Manunggal",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "485",
                    "nama_bank" => "Bank MNC / Bank Bumiputera",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "490",
                    "nama_bank" => "Bank Yudha Bhakti",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "494",
                    "nama_bank" => "Bank BRI Agro",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "498",
                    "nama_bank" => "Bank Indomonex (Bank SBI Indonesia)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "501",
                    "nama_bank" => "Bank Royal Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "503",
                    "nama_bank" => "Bank Alfindo (Bank National Nobu)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "506",
                    "nama_bank" => "Bank Syariah Mega",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "513",
                    "nama_bank" => "Bank Ina Perdana",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "517",
                    "nama_bank" => "Bank Harfa",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "510",
                    "nama_bank" => "Prima Master Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "521",
                    "nama_bank" => "Bank Persyarikatan Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "526",
                    "nama_bank" => "Bank Akita",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "526",
                    "nama_bank" => "Liman International Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "531",
                    "nama_bank" => "Anglomas Internasional Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "523",
                    "nama_bank" => "Bank Dipo International (Bank Sahabat Sampoerna)",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "535",
                    "nama_bank" => "Bank Kesejahteraan Ekonomi",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "542",
                    "nama_bank" => "Bank Artos IND",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "547",
                    "nama_bank" => "Bank Purba Danarta",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "548",
                    "nama_bank" => "Bank Multi Arta Sentosa",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "553",
                    "nama_bank" => "Bank Mayora Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "555",
                    "nama_bank" => "Bank Index Selindo",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "559",
                    "nama_bank" => "Centratama Nasional Bank",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "566",
                    "nama_bank" => "Bank Victoria International",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "562",
                    "nama_bank" => "Bank Fama Internasional",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "564",
                    "nama_bank" => "Bank Mandiri Taspen Pos",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "567",
                    "nama_bank" => "Bank Harda",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "945",
                    "nama_bank" => "Bank Agris",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "956",
                    "nama_bank" => "Bank Merincorp",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "947",
                    "nama_bank" => "Bank Maybank Indocorp",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "948",
                    "nama_bank" => "Bank OCBC – Indonesia",
                    "logo" => "default.png"
                ],
                [
                    "kode_bank" => "949",
                    "nama_bank" => "Bank CTBC (China Trust) Indonesia",
                    "logo" => "default.png"
                ]
            ];

            foreach ($temp as $t) {
                $status = new Bank();
                $status->kode_bank = $t['kode_bank'];
                $status->nama_bank = $t['nama_bank'];
                $status->logo = $t['logo'];
                $status->save();
            }
        }
    }
}
