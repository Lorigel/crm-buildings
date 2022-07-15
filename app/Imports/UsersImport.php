<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
use DateTimeZone;
use Illuminate\Validation\Rule;

class UsersImport implements WithHeadingRow, WithChunkReading, ShouldQueue, SkipsOnFailure, WithUpserts, OnEachRow, WithValidation
{
    use Importable, RegistersEventListeners;

    protected $role;

    public function __construct($role)
    {
        $this->role = $role;

        Session::put('failed_rows', []);
        Session::put('updated_rows', []);
    }

    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        $mandatory_headers = [
            'email',
            'nome',
            'cognome',
            'username'
        ];

        foreach ($mandatory_headers as $mandatory_header) {
            if (!isset($row[$mandatory_header])) {
                return null;
            }
        }

        $user = User::updateOrCreate([
            'email' => $row['email'],
        ], [
            'username'              => $row['username'],
            'name'                  => $row['nome'],
            'surname'               => $row['cognome'],
            'assigned_to'           => $this->getAssignedToID($row['assegnato_a']),
            'business_name'         => $row['ragione_sociale'],
            'address'               => $row['indirizzo'],
            'postal_code'           => $row['cap'],
            'city'                  => $row['citta'],
            'province'              => $row['provincia'],
            'vat_number'            => $row['p_iva'],
            'fiscal_number'         => $row['codice_fiscale'],
            'phone_number'          => $row['telephono'],
            'mobile_number'         => $row['cellulare'],
            'pec'                   => $row['pec'],
            'note'                  => $row['note'],
            'role'                  => $this->role,
            'password'              => Hash::make(Str::random(12)),
            'email_verified_at'     => (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s'),
            'account_verified_at'   => (new DateTime('now', new DateTimeZone('Europe/Rome')))->format('Y-m-d H:i:s')
        ]);

        if (!$user->wasRecentlyCreated) {
            Session::push('updated_rows', $rowIndex);
        }
    }

    public function rules(): array
    {
        $master_role = Role::where('slug', 'master')->first();
        
        return [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'assegnato_a' => [Rule::requiredIf($this->role != $master_role->id), function($attribute, $value, $fail){
                if(!User::where('email', $value)->first()){
                    $fail('User with email' . $value . ' does not exist');
                }
            }],
            'p_iva' => 'numeric|digits:11|nullable',
        ];
    }

    public function chunkSize(): int
    {
        return 300;
    }

    public function onFailure(Failure ...$failures)
    {
        Session::push('failed_rows', $failures[0]);
    }

    protected function getAssignedToID($mail)
    {
        $user = User::where('email', $mail)->first();
        return $user ? $user->id : null;
    }
}
