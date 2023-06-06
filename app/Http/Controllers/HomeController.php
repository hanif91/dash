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
        $btn1ket = "Surplus/Defisit Kas Bulan Lalu";

        $tglawaltahun = date_create(date('Y-01-01'));
        $tglblnini = date_add(date_create(date('Y-m-t')),date_interval_create_from_date_string('-1 month')); // = bulanlalu
        $periodeini = date_format($tglblnini,'Ym'); // = bulanlalu
        $nmuser = 'admin';
        $kodelhk ="kodelhk";
        $valuekodelhk = "sumd";
        $btn2ket = "Laba / Rugi Bulan Lalu";


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





        $arrayrow1 = array('btn1' => $databtn1);
        $arrayrow1 = Arr::add($arrayrow1,"btn2",$databtn2);
        $arrayrow1 = Arr::add($arrayrow1,"btn3","Tes3");
        $arrayrow1 = Arr::add($arrayrow1,"btn4","Tes4");
        $arrayrow1 = Arr::add($arrayrow1,"btn1ket",$btn1ket);
        $arrayrow1 = Arr::add($arrayrow1,"btn2ket",$btn2ket);
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
