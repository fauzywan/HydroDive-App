<?php

namespace Database\Seeders;

use App\Models\Category as Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $no_acara=0;
        $style = ["GAYA BEBAS", "GAYA BEBAS PAPAN", "GAYA BEBAS KAKI"];
        $type = ['LCM', 'SCM'];
        $gender = ["PRIA", "WANITA"];

        $distance = [['50 M', '100 M', '200 M', "400 M"], ["25 M", "50 M", "100 M", "150 M", "200 M"]];
        $no = 0;
        $sstyle = ["GAYA PUNGGUNG", "GAYA DADA"];

        foreach ($type as $tt) {
            foreach ($distance[$no] as $d1) {
                foreach ($gender as $g) {
                    foreach ($sstyle as $ss) {
                        Event::create([
                            "no" => $no_acara,
                            "distance" => $d1,
                            "style" => "$ss",
                            "gender" => $g,
                            "pool_type" => $tt,
                            "relay" => 0,
                            "description" => "$d1 $ss $g $tt"
                        ]);
                    }
                }
            }
            $no++;
        }

        $distance = [['50 M', '100 M', '200 M', "400 M", "800 M", "1500 M"], ["25 M", "50 M", "100 M", "150 M", "200 M", "400 M", "800 M", "1500 M"]];
        $no = 0;

        foreach ($type as $tt) {
            foreach ($distance[$no] as $d1) {
                foreach ($gender as $g) {
                    Event::create([
                        "no" => $no_acara,
                        "distance" => $d1,
                        "style" => "GAYA BEBAS",
                        "gender" => $g,
                        "pool_type" => $tt,
                        "relay" => 0,
                        "description" => "$d1 GAYA BEBAS $g $tt"
                    ]);
                }
            }
            $no++;
        }

        $distance = ["50 M", "25 M"];
        $style2 = ["GAYA BEBAS", "GAYA DADA"];
        $no = 0;

        foreach ($type as $tt) {
            foreach ($gender as $g) {
                foreach ($style2 as $s2) {
                    Event::create([
                        "no" => $no_acara,
                        "distance" => $distance[$no],
                        "style" => "$s2 KAKI",
                        "gender" => $g,
                        "pool_type" => $tt,
                        "relay" => 0,
                        "description" => "$distance[$no] $s2 KAKI $g $tt"
                    ]);
                }
            }
            $no++;
        }

        for ($i = 0; $i < 2; $i++) {
            Event::create([
                "no" => $no_acara,
                "distance" => "50 M",
                "style" => "GAYA BEBAS PAPAN",
                "gender" => $gender[$i],
                "pool_type" => $type[$i],
                "relay" => 0,
                "description" => "50 M GAYA BEBAS PAPAN {$gender[$i]} {$type[$i]}",
            ]);
        }

        $distance2 = [['50 M', '100 M', '200 M'], ["25 M", "50 M", "100 M", "200 M"]];
        $no = 0;
        $style2 = ["GAYA BEBAS", "GAYA GABUNGAN"];

        foreach ($type as $tt) {
            foreach ($distance2[$no] as $d2) {
                foreach ($style2 as $s2) {
                    Event::create([
                        "no" => $no_acara,
                        "distance" => "4x$d2",
                        "style" => "$s2",
                        "gender" => "CAMPURAN",
                        "pool_type" => $tt,
                        "relay" => 1,
                        "description" => "4x$d2 $s2 CAMPURAN $tt ESTAFET"
                    ]);
                }
            }
            $no++;
        }

        $no = 0;
        $style2 = ["GAYA BEBAS", "GAYA GABUNGAN"];

        foreach ($type as $tt) {
            foreach ($style2 as $s2) {
                foreach ($distance2[$no] as $d2) {
                    foreach ($gender as $g) {
                        Event::create([
                            "no" => $no_acara,
                            "distance" => "4x$d2",
                            "style" => "$s2",
                            "gender" => $g,
                            "pool_type" => $tt,
                            "relay" => 1,
                            "description" => "4x$d2 $s2 $g $tt ESTAFET"
                        ]);
                    }
                }
            }
            $no++;
        }

        $distance = [['150 M', '200 M', "400 M"], ["100 M", "150 M", "200 M", "400 M"]];
        $no = 0;

        foreach ($type as $tt) {
            foreach ($distance[$no] as $d1) {
                foreach ($gender as $g) {
                    Event::create([
                        "no" => $no_acara,
                        "distance" => $d1,
                        "style" => "PERORANGAN GAYA GABUNGAN",
                        "gender" => $g,
                        "pool_type" => $tt,
                        "relay" => 0,
                        "description" => "$d1 PERORANGAN GAYA GABUNGAN $g $tt"
                    ]);
                }
            }
            $no++;
        }

        $distance = [['50 M', '100 M', '200 M', "200 M"], ["25 M", "50 M", "100 M", "150 M", "200 M"]];
        $no = 0;
        $sstyle = ["GAYA PUNGGUNG", "GAYA DADA"];

        foreach ($type as $tt) {
            foreach ($distance[$no] as $d1) {
                foreach ($gender as $g) {
                    foreach ($sstyle as $ss) {
                        Event::create([
                            "no" => $no_acara,
                            "distance" => $d1,
                            "style" => "$ss",
                            "gender" => $g,
                            "pool_type" => $tt,
                            "relay" => 0,
                            "description" => "$d1 $ss $g $tt"
                        ]);
                    }
                }
            }
            $no++;
        }
    }
}
