<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function convertnumber ($numbervalue)
    {
        if ($numbervalue >= 1000000000 ||  $numbervalue <= -1000000000) {
            return 'Rp. ' . number_format($numbervalue / 1000000000, 2) . ' M';
        } else if ($numbervalue >= 1000000 ||  $numbervalue <= -1000000) {
            return 'Rp. ' . number_format($numbervalue / 1000000, 2) . ' Jt';
        } else if ($numbervalue >= 1000 ||  $numbervalue <= -1000) {

            return 'Rp. ' .  number_format($numbervalue / 1000, 2) . ' Rb';

        } else {
            return 'Rp. ' . number_format($numbervalue);
        }
    }

    public function index()
    {
        // variable Kas
        $tgl1 = date_add(date_create(date('Y-m-01')),date_interval_create_from_date_string('-1 month'));
        $tgl2 = date_add(date_create(date('Y-m-t')),date_interval_create_from_date_string('-1 month'));
        $btn1ket = "Surplus/Defisit kas bulan lalu";

        $tglawaltahun = date_create(date('Y-01-01'));
        $tglblnini = date_add(date_create(date('Y-m-t')),date_interval_create_from_date_string('-1 month')); // = bulanlalu
        $periodeini = date_format($tglblnini,'Ym'); // = bulanlalu

        $periodebacaini = date('Ym'); // = bulanini

        $nmuser = 'admin';
        $kodelhk ="kodelhk";
        $valuekodelhk = "sumd";
        $btn2ket = "Laba / Rugi bulan lalu";


        //START processs btn1
        $data2 = DB::select('call ex_lhk_rep(?,?,?)', array($tgl1,$tgl2,$nmuser) );

        $data1 = DB::select('call view_lhk(?,?)', array(1,$nmuser) );
        $datacollect = collect($data1);

        $datafiltercollectpen = $datacollect->where('kodelhk','=','sumd')->first()->total??0;
        $datafiltercollectkel = $datacollect->where('kodelhk','=','sumk')->first()->total??0;

        $jumlahsurpluskas = $datafiltercollectpen -  $datafiltercollectkel;



        $databtn1 = $this->convertnumber($jumlahsurpluskas);
        //END PROCESS btn1

        //START processs btn2

        $data1 = DB::select('CALL `ex_lr_detail`(?,?,?,?,?)', array($tglawaltahun,$tglblnini,$periodeini,$nmuser,0));

        $data2 = DB::select('call `viewlap_lr_desk`(?)', array($nmuser));
        $datacollect = collect($data2);
        $datacollect = $datacollect->where('sub0','=',"4");
        $datasumcollect = $datacollect->sum('blnrealisasisum')??0;

        $databtn2 = $this->convertnumber($datasumcollect);
        //end proces btn2

        //start procecs btn3
        $btn3ket = "Pembacaan belum terbaca bulan ini";
         $databtn3 = DB::connection('mysql_rekening')->table("bacameters")
                ->where('periode_baca','=',$periodebacaini)
                ->where('sudah_baca',"=",'0')
                ->count();

        $databtn3 = number_format($databtn3);
        //end proces btn3


        //start procecs btn4
        $btn4ket = "Keluhan yang belum tertangani bulan ini";
         $databtn4 = DB::connection('mysql_hublang')->table("pengaduan")
                ->whereYear('created_at',date('Y'))
                ->whereMonth('created_at',date('m'))
                ->where('is_complete','0')
                ->count();

        $databtn4 = number_format($databtn4);
        //end proces btn4






        $arrayrow1 = array('btn1' => $databtn1);
        $arrayrow1 = Arr::add($arrayrow1,"btn2",$databtn2);
        $arrayrow1 = Arr::add($arrayrow1,"btn3",$databtn3);
        $arrayrow1 = Arr::add($arrayrow1,"btn4",$databtn4);
        $arrayrow1 = Arr::add($arrayrow1,"btn1ket",$btn1ket);
        $arrayrow1 = Arr::add($arrayrow1,"btn2ket",$btn2ket);
        $arrayrow1 = Arr::add($arrayrow1,"btn3ket",$btn3ket);
        $arrayrow1 = Arr::add($arrayrow1,"btn4ket",$btn4ket);

        //dd($arrayrow1);
        return view('home', compact('arrayrow1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
