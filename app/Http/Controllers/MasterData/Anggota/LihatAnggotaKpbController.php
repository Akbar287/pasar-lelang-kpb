<?php

namespace App\Http\Controllers\MasterData\Anggota;

use App\Http\Controllers\Controller;
use App\Models\MemberKpb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LihatAnggotaKpbController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw');
            $request['page'] = ($request->get('start') / $request->get('length')) + 1;
            $length = $request->get('length');
            $search = $request->search['value'];

            if ($search != "") {
                $total_members = MemberKpb::where('nik', 'like', '%' . $search . '%')->count();
                $data = MemberKpb::where('nik', 'like', '%' . $search . '%')->paginate($length)->toArray();
            } else {
                $total_members = MemberKpb::count();
                $data = MemberKpb::orderBy('nik', 'asc')->paginate($length)->toArray();
            }

            $myData = [];

            foreach ($data['data'] as $d) {
                if (is_null($d['is_member_lelang'])) {
                    $temp = '<div class="badge badge-secondary">Belum Diatur</div>';
                } else {
                    if ($d['is_member_lelang']) {
                        $temp = '<div class="badge badge-success">Anggota Pasar Lelang</div>';
                    } else {
                        $temp = '<div class="badge badge-danger">Diatur Sebagai Bukan Anggota</div>';
                    }
                }
                $myData[] = [
                    'nik' => $d['nik'],
                    'nama' => $d['nama'],
                    'status' => $temp,
                    'action' => '<a class="btn btn-primary" href="' . route('master.anggota.kpb.show', $d['nik']) . '">Detail</a>'
                ];
            }

            $res = array(
                'draw' => $draw,
                'recordsTotal' => $total_members,
                'recordsFiltered' => $total_members,
                'data' => $myData,
            );

            return response()->json($res, 200);
        }
        return view('master_data.anggota_pasar_lelang.anggota_kpb.index');
    }

    public function show(Request $request, $nik)
    {
        $calon = MemberKpb::where('nik', $nik)->first();
        $opt = [
            'provinsi' => is_null($calon->provinsi_id) || empty($calon->provinsi_id) || $calon->provinsi_id == 'null' ? null : DB::table('reg_provinces')->where('id', $calon->provinsi_id)->first()->name,
            'kabupaten' => is_null($calon->kabupaten_id) || empty($calon->kabupaten_id) || $calon->kabupaten_id == 'null' ? null : DB::table('reg_regencies')->where('id', $calon->kabupaten_id)->first()->name,
            'kecamatan' => is_null($calon->kecamatan_id) || empty($calon->kecamatan_id) || $calon->kecamatan_id == 'null' ? null : DB::table('reg_districts')->where('id', $calon->kecamatan_id)->first()->name,
            'desa' => is_null($calon->desa_id) || empty($calon->desa_id) || $calon->desa_id == 'null' ? null : DB::table('reg_villages')->where('id', $calon->desa_id)->first()->name
        ];

        return view('master_data.anggota_pasar_lelang.anggota_kpb.show', compact('calon', 'opt'));
    }

    public function update(Request $request, $nik)
    {
        $request->validate(['confirm' => ['required']]);

        $calon = MemberKpb::where('nik', $nik)->first();

        if (is_null($calon)) {
            return redirect('/master/anggota/kpb/' . $nik)->with('msg', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Anggota KPB tidak ditemukan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            if ($request->confirm == '1') {
                DB::table('member_kpb')->where('nik', $nik)->update(['is_member_lelang' => true]);
                return redirect('/master/anggota/kpb/' . $nik)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Ditandai sebagai anggota Pasar Lelang KPB.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                DB::table('member_kpb')->where('nik', $nik)->update(['is_member_lelang' => false]);
                return redirect('/master/anggota/kpb/' . $nik)->with('msg', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!</strong> Ditandai Sebagai Bukan Anggota Pasar Lelang.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        }
    }
}
