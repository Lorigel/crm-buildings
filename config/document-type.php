<?php

return [
    'agent' => [
        [
            'value' => 'contract',
            'name' => 'PDA sottoscritta committente',
            'required' => true
        ],
        [
            'value' => 'inspection_report',
            'name' => 'Verbale di sopralluogo',
            'required' => true
        ],
        [
            'value' => 'ape',
            'name' => 'APE Immobile',
            'required' => true
        ],
        [
            'value' => 'deed_of_origin',
            'name' => 'Atto di provenienza committente'
        ],
        [
            'value' => 'licences_with_approved_graphics',
            'name' => 'Licenze o concessioni edilizie con grafici assentiti',
            'required' => true
        ],
        [
            'value' => 'self_certification',
            'name' => 'Autocertificazione proprietario e regolarita',
            'required' => true
        ],
        [
            'value' => 'pending_tax_loads',
            'name' => 'Certificato dei carichi pendenti fiscali'
        ],
        [
            'value' => 'procurement_agreement',
            'name' => 'Contratto di appalto unita\' singola'
        ],
        [
            'value' => 'cila',
            'name' => 'Delega per documento cila (immobile)'
        ],
        [
            'value' => 'conformity_declaration',
            'name' => 'Dichiarazione del cliente sulla conformita\' dei documenti consegnati in copia ris',
            'required' => true
        ],
        [
            'value' => 'kyc',
            'name' => 'Documenti di identita\' committente',
            'required' => true
        ],
        [
            'value' => 'telematic_transmission',
            'name' => 'Impegno alla trasmissione telematica Committente'
        ],
        [
            'value' => 'licenses_in_amnesty',
            'name' => 'Licenze o Concessioni in sanatoria ovvero Condoni esitati con relativi grafici'
        ],
        [
            'value' => 'catastal_plan',
            'name' => 'Planimetria catastale (immobile)',
            'required' => true
        ],
        [
            'value' => 'questionnaire',
            'name' => 'Questinonario Eco-Sisma Bonus'
        ],
        [
            'value' => 'catastal_survey',
            'name' => 'Visura catastale (immobile)',
            'required' => true
        ],
        [
            'value' => 'other',
            'name' => 'Altro'
        ]
    ],
    'technic' => [
        [
            'value' => 'completed_project',
            'name' => 'Proggetto completo per la PTR',
            'required' => true
        ],
        [
            'value' => 'cilas',
            'name' => 'CILAS',
            'required' => true
        ],
        [
            'value' => 'feasibility',
            'name' => 'Relazione di fattibilita',
            'required' => true
        ],
    ],
    'condominium' => [
        [
            'value' => 'contract',
            'name' => 'PDA',
        ],
        [
            'value' => 'inspection_report',
            'name' => 'Verbale di primo sopralluogo completo di rilievo fotografico delle parti che saranno oggetto di intervento',
        ],
        [
            'value' => 'kyc',
            'name' => 'Documento d\'identità e codice fiscale dei soggetti committenti beneficiario della detrazione',
        ],
        [
            'value' => 'signed_shareholders_resolution',
            'name' => 'Copia firmata della delibera assembleare',
        ],
        [
            'value' => 'catastal_survey',
            'name' => 'Certificati catastali (visure e mappe aggiornate) di ciascuna delle unità immobiliari interessate dagli interventi edilizi agevolati',
        ],
    ]
];
