<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $masyarakat = Masyarakat::all();
            return DataTables::of($masyarakat)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center">';
                    $editButton = '<form action="' . route('masyarakat.edit', ['masyarakat' => $row->id]) . '" method="GET">
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light me-1" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-custom-class="tooltip-success"
                        data-bs-original-title="Ubah"><i class="fas fa-edit"></i></button>
                        </form>';
                    $btn .= $editButton;

                    $deleteButton = '<form action="' . route('masyarakat.destroy', ['masyarakat' => $row->id]) . '" method="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="delete"> 
                        <button type="submit" id="btn-delete" class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-danger" data-bs-original-title="Hapus"><i class="fas fa-trash-alt"></i></button>
                        </form></div>';
                    $btn .= $deleteButton;

                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('umur', fn($row): string => (\Carbon\Carbon::now()->year - $row->tanggal_lahir->year) . " Tahun")
                ->rawColumns(['action', 'umur'])
                ->make(true);
        }
        $data['title'] = 'Masyarakat';
        return view('admin.masyarakat.masyarakat', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['agama'] = [
            'kristen',
            'buddha',
            'islam',
            'hindu'
        ];
        $data['sk'] = [Masyarakat::$STATUS_KAWIN_LAJANG, Masyarakat::$STATUS_KAWIN_MENIKAH];
        $data['jk'] = [
            ["jenis_kelamin" => 'Laki-laki', 'name' => 'Laki-Laki'],
            ['jenis_kelamin' => 'Perempuan', 'name' => 'Perempuan']
        ];
        $data['title'] = 'Tambah Pemilih';
        return view('admin.masyarakat.masyarakat-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nik' => [
                'required',
                Rule::unique('masyarakats', 'nik')
            ],
            'nama_lengkap' => 'required|string|max:255',
            'foto' => 'nullable|mimes:jpeg,jpg,png,gif,svg|max:4096',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'tempat_lahir' => 'required|string',
            'alamat' => 'required',
            'agama' => [Rule::in([
                'kristen',
                'buddha',
                'islam',
                'hindu'
            ])],
            'status_kawin' => 'nullable|in:lajang,menikah'
        ]);
        $data = $request->all();
        dd($data);
        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('masyarakat-img');
        }
        $ms = Masyarakat::create($data);
        User::create(
            [
                'username' => explode(" ", $ms->nama_lengkap . \Carbon\Carbon::now()->toDateTimeString(unitPrecision: 'minute'))[0],
                'password' => Hash::make('123456'),
                'masyarakat_id' => $ms->id
            ]
        );

        Alert::success('Success', 'Data berhasil disimpan !');
        return redirect()->route('masyarakat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['title'] = 'Edit Pemilh';
        $data['agama'] = [
            'kristen',
            'buddha',
            'islam',
            'hindu'
        ];
        $data['sk'] = [Masyarakat::$STATUS_KAWIN_LAJANG, Masyarakat::$STATUS_KAWIN_MENIKAH];
        $data['jk'] = [
            ["jenis_kelamin" => 'Laki-laki', 'name' => 'Laki-Laki'],
            ['jenis_kelamin' => 'Perempuan', 'name' => 'Perempuan']
        ];
        $data['masyarakat'] = Masyarakat::findOrFail($id);
        return view('admin.masyarakat.masyarakat-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nik' => [
                'required',
                Rule::unique('masyarakats', 'nik')->ignore($id, 'id')
            ],
            'nama_lengkap' => 'required|string|max:255',
            'foto' => 'nullable|mimes:jpeg,jpg,png,gif,svg|max:4096',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'tempat_lahir' => 'required|string',
            'alamat' => 'required',
            'agama' => [Rule::in([
                'kristen',
                'buddha',
                'islam',
                'hindu'
            ])],
            'status_kawin' => 'nullable|in:lajang,menikah'
        ]);
        $ms = Masyarakat::findOrFail($id);

        $data = $request->all();
        if ($request->file('foto')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['foto'] = $request->file('foto')->store('masyarakat-img');
        }
        $ms->update($data);
        Alert::info('Success', 'Data berhasil diupdate !');
        return redirect()->route('masyarakat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deletedms = Masyarakat::findOrFail($id);
            if ($deletedms->image) {
                Storage::delete($deletedms->image);
            }
            $deletedms->delete();
            Alert::success('Success', 'Data berhasil dihapus !');
            return redirect()->route('masyarakat.index');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Tidak bisa dihapus, Data sudah digunakan !');
            return redirect()->route('masyarakat.index');
        }
    }
}
