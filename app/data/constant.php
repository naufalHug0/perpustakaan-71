<?php

$categories = Kategori::select([
    [
        'name'=>'f_id',
        'alias'=>'id'
    ],
    [
        'name'=>'f_kategori',
        'alias'=>'value'
    ]
]);

$anggota = Anggota::select([
    [
        'name'=>'f_id',
        'alias'=>'id'
    ],
    [
        'name'=>'f_nama',
        'alias'=>'value'
        ]
    ]);

$judul_buku = Buku::select([
    [
        'name' => 't_buku.f_id',
        'alias' => 'id'
    ],
    [
        'name' => 'f_judul',
        'alias' => 'value'
    ]
], 'add');

$forms = [
    'kategori' => [
        'title' => 'Kategori',
        'inputs' => [
            'kategori' => [
                'type' => 'text',
                'name' => 'kategori',
                'placeholder' => 'Nama Kategori'
            ]
        ]
    ],
    'buku' => [
        'title' => 'Buku',
        'inputs' => [
            'judul' => [
                'type' => 'text',
                'name' => 'judul',
                'placeholder' => 'Judul Buku'
            ],
            'pengarang' => [
                'type' => 'text',
                'name' => 'pengarang',
                'placeholder' => 'Pengarang'
            ],
            'penerbit' => [
                'type' => 'text',
                'name' => 'penerbit',
                'placeholder' => 'Penerbit'
            ],
            'kategori' => [
                'type' => 'select',
                'name' => 'kategori',
                'placeholder' => 'Kategori',
                'options' => $categories
            ],
            'image' => [
                'type' => 'file',
                'name' => 'image'
            ],
            'stok' => [
                'type' => 'number',
                'name' => 'stok',
                'placeholder' => 'Stok',
                'atributes' => ' step="any" min="1" '
            ],
            'desc' => [
                'type' => 'textarea',
                'name' => 'desc',
                'placeholder' => 'Deskripsi'
            ],
        ]
    ],
    'anggota' => [
        'title' => 'Anggota',
        'inputs' => [
            'nama' => [
                'type' => 'text',
                'name' => 'nama',
                'placeholder' => 'Nama'
            ],
            'username' => [
                'type' => 'text',
                'name' => 'username',
                'placeholder' => 'Username'
            ],
            'password' => [
                'type' => 'password',
                'name' => 'password',
                'placeholder' => 'Password'
            ],
            'tempat-lahir' => [
                'type' => 'text',
                'name' => 'tempat-lahir',
                'placeholder' => 'Tempat Lahir'
            ],
            'tgl-lahir' => [
                'type' => 'date',
                'name' => 'tgl-lahir',
                'placeholder' => 'Tanggal Lahir'
            ],
        ]
    ],
    'admin' => [
        'title' => 'Admin',
        'inputs' => [
            'nama' => [
                'type' => 'text',
                'name' => 'nama',
                'placeholder' => 'Nama'
            ],
            'username' => [
                'type' => 'text',
                'name' => 'username',
                'placeholder' => 'Username'
            ],
            'password' => [
                'type' => 'password',
                'name' => 'password',
                'placeholder' => 'Password'
            ],
            'status' => [
                'type' => 'select',
                'name' => 'status',
                'placeholder' => 'Status',
                'options' => [
                    ["value"=>'Aktif', 'id'=>'Aktif'],
                    ["value"=>'Tidak Aktif', 'id'=>'Tidak Aktif'],
                ]
            ],
            'level' => [
                'type' => 'select',
                'name' => 'level',
                'placeholder' => 'Level',
                'options' => [
                    ["value"=>'admin', 'id'=>'admin'],
                    ["value"=>'pustakawan', 'id'=>'pustakawan'],
                ]
            ],
        ]
    ],
    'peminjaman' => [
        'title' => 'Peminjaman',
        'inputs' => [
            'anggota' => [
                'type' => 'select',
                'name' => 'anggota',
                'placeholder' => 'Anggota yang meminjam',
                'options' => array_map(function ($a) {
                    return ['id'=>$a['id'], 'value'=> $a['id'].' - '.$a['value']];
                },$anggota)
            ],
            'judul' => [
                'type' => 'select',
                'name' => 'judul',
                'placeholder' => 'Judul Buku',
                'options' => array_map(function ($j) {
                    return ['id'=>$j['id'], 'value'=> $j['id'].' - '.$j['value']];
                },$judul_buku)
            ],
            'tgl-pinjam' => [
                'type' => 'date',
                'name' => 'tgl-pinjam',
                'placeholder' => 'Tanggal Peminjaman'
            ],
        ],
        'edit_inputs' => [
            'judul' => [
                'type' => 'select',
                'name' => 'judul',
                'placeholder' => 'Judul Buku',
                'options' => 
                array_map(function ($j) {
                    return ['id'=>$j['id'], 'value'=> $j['id'].' - '.$j['value']];
                },Buku::select([
                    [
                        'name' => 't_buku.f_id',
                        'alias' => 'id'
                    ],
                    [
                        'name' => 'f_judul',
                        'alias' => 'value'
                    ]
                ], 'edit'))
            ],
            'tgl-pinjam' => [
                'type' => 'date',
                'name' => 'tgl-pinjam',
                'placeholder' => 'Tanggal Peminjaman'
            ]
        ]
    ]
];

$EXPORT_TABLE_COLUMNS = [
    'laporan' => [
        'most_rent' => [
            [
                'title' => 'Judul Buku',
                'width'=>'50'
            ]
        ],
        'unreturned_book' => [
            [
                'title' => 'Judul',
                'width'=>'50'
            ],
            [
                'title'=>'Pengarang',
                'width'=>'50'
            ],
            [
                'title' => 'Penerbit',
                'width'=>'50'
            ],
            [
                'title' => 'Stok',
                'width'=>'10'
            ]
        ],
        'unreturned_books_member' => [
            [
                'title' => 'Nama Anggota',
                'width'=>'50'
            ],
            [
                'title' => 'Jumlah Buku',
                'width' =>'23'
            ]
        ],
        'most_rent_member' => [
            [
                'title' => 'Nama Anggota',
                'width'=>'50'
            ],
            [
                'title' => 'Jumlah Buku',
                'width' =>'23'
            ]
        ]
    ],
    'peminjaman' => [
        [
            'title' => 'Judul',
            'width'=>'50'
        ],
        [
            'title' => 'Kategori',
            'width'=>'30'
        ],
        [
            'title' => 'Admin',
            'width'=>'30'
        ],
        [
            'title' => 'Anggota',
            'width'=>'30'
        ],
        [
            'title' => 'Tanggal Pinjam',
            'width'=>'50'
        ],
        [
            'title' => 'Tanggal Kembali',
            'width'=>'50'
        ],
        [
            'title' => 'Status',
            'width'=>'30'
        ],
    ]
];