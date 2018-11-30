<img src="logo.png">

# Tugas Besar 2 IF3110 Pengembangan Aplikasi Berbasis Web

### Persembahan dari:
* 13516086 Dandy Arif Rahman
* 13516098 Rifqi Rifaldi Utomo
* 13516107 Senapati Sang Diwangkara

## Table Of Contents
- [Deskripsi Aplikasi](#deskripsi-aplikasi)
- [Perubahan Pada Aplikasi ProBook](#perubahan-pada-aplikasi-probook)
- [Skenario](#skenario)
- [Struktur Basis Data](#struktur-basis-data)
- [Konsep Shared Session](#konsep-shared-session)
- [Token dan Expiry Time](#token-dan-expiry-time)
- [Kelebihan dan Kelemahan](#kelebihan-dan-kelemahan)
- [Pembagian Tugas](#pembagian-tugas)
- [About](#about)

## Deskripsi Aplikasi

Pada tugas ini, kami melakukan *upgrade* Website toko buku online pada Tugas 1 dengan mengaplikasikan arsitektur web service **REST** dan **SOAP**. Arsitektur aplikasi diubah agar memanfaatkan 2 buah webservice, yaitu **webservice bank** dan *webservice buku**. Baik aplikasi maupun kedua webservice, masing-masing memiliki database sendiri.

### Webservice bank

Kami membuat sebuah webservice bank sederhana yang dibangun di atas **node.js**. Webservice bank memiliki database sendiri yang menyimpan informasi nasabah dan informasi transaksi. Informasi nasabah berisi nama, nomor kartu, dan saldo. Informasi transaksi berisi nomor kartu pengirim, nomor kartu penerima, jumlah, waktu transaksi. 

Webservice bank diimplementasikan menggunakan protokol **REST**. Webservice bank menyediakan service untuk **validasi nomor kartu** dan **transfer**.

- Service validasi nomor kartu dilakukan dengan memeriksa apakah nomor kartu tersebut ada pada database bank. Jika iya, berarti kartu tersebut valid.
  
- Service transfer menerima input nomor kartu pengirim, penerima, dan jumlah yang ditransfer. Jika saldo mencukupi, maka transfer berhasil dan uang sejumlah tersebut dipindahkan dari pengirim ke penerima. Transaksi tersebut juga dicatat dalam database webservice. Jika saldo tidak mencukupi, maka transaksi ditolak dan tidak dicatat di database.
  
### Webservice buku

Webservice ini menyediakan daftar buku beserta harganya yang akan digunakan oleh aplikasi pro-book. Webservice buku dibangun di atas **java servlet**. Service yang disediakan webservice ini antara lain adalah pencarian buku, mengambil detail buku, melakukan pembelian, serta memberikan rekomendasi buku sederhana. Webservice ini diimplementasikan menggunakan **JAX-WS dengan protokol SOAP**.

Webservice ini memanfaatkan **Google Books API melalui HttpURLConnection. Data-data buku yang dimiliki oleh webservice ini akan mengambil dari Google Books API. Data pada Google Books API tidak memiliki harga, maka webservice buku memiliki database sendiri yang berisi data harga buku-buku yang dijual. 

Detail service yang disediakan webservice ini adalah:

- Pencarian buku menerima keyword judul. Keyword ini akan diteruskan ke Google Books API dan mengambil daftar buku yang mengandung keyword tersebut pada judulnya. Hasil tersebut kemudian dikembalikan pada aplikasi setelah diproses. Proses yang dilakukan adalah menghapus data yang tidak dibutuhkan, menambahkan harga buku jika ada di database, dan mengubahnya menjadi format SOAP.

- Pengambilan detail juga mengambil data dari Google Books API, seperti service search. Baik service ini maupun search, informasi yang akan dikembalikan hanya informasi yang dibutuhkan. Jangan lansung melemparkan semua data yang didapatkan dari Google Books API ke aplikasi. Karena pengambilan detail buku menggunakan ID buku, maka ID buku webservice harus mengikuti ID buku Google Books API. Pada service ini, harga buku juga dicantumkan.

- Webservice ini menangani proses pembelian. Service ini menerima masukan id buku yang dibeli, jumlah yang dibeli, serta nomor rekening user yang membeli buku. Nomor rekening tersebut akan digunakan untuk mentransfer uang sejumlah harga total buku. Jika transfer gagal, maka pembelian buku juga gagal.

- Jumlah buku yang berhasil dibeli dicatat di database. Webservice menyimpan ID buku, kategori (genre), dan jumlah total pembelian buku tersebut. Data ini akan digunakan untuk memberikan rekomendasi. Jika pembelian gagal maka data tidak dicatat pada aplikasi.

- Webservice juga dapat memberikan rekomendasi sederhana. Input dari webservice ini adalah kategori buku. Kategori buku yang dimasukkan boleh lebih dari 1. Buku yang direkomendasikan adalah buku yang memiliki jumlah pembelian total terbanyak yang memiliki kategori yang sama dengan daftar kategori yang menjadi input. Data tersebut didapat dari service yang mencatat jumlah pembelian.
  
- Jika buku dengan kategori tersebut belum ada yang terjual, maka webservice akan mengembalikan 1 buku random dari hasil pencarian pada Google Books API. Pencarian yang dilakukan adalah buku yang memiliki kategori yang sama dengan salah satu dari kategori yang diberikan (random).
  
## Perubahan Pada Aplikasi Pro-book

- Setiap user menyimpan informasi nomor kartu yang divalidasi menggunakan webservice bank. Validasi dilakukan ketika melakukan registrasi atau mengubah informasi nomor kartu. Jika nomor kartu tidak valid, registrasi atau update profile gagal dan data tidak berubah.

- Data buku diambil dari webservice buku, sehingga aplikasi tidak menyimpan data buku secara lokal. Setiap kali aplikasi membutuhkan informasi buku, aplikasi akan melakukan request kepada webservice buku. Hal ini termasuk proses search dan melihat detail buku.

- Database webservice cukup menyimpan harga sebagian buku yang ada di Google Books API. Buku yang harganya tidak terdefinisikan di database dicantumkan NOT FOR SALE dan tidak bisa dibeli, tetapi tetap bisa dilihat detailnya.

- Proses pembelian buku pada aplikasi ditangani oleh webservice buku. Status pembelian (berhasil/gagal dan alasannya) dilaporkan kepada user dalam bentuk notifikasi. Untuk kemudahan, tidak perlu ada proses validasi dalam melakukan transfer

- Pada halaman detail buku, terdapat rekomendasi buku yang didapatkan dari webservice buku.

- Halaman search-book dan search-result pada tugas 1 digabung menjadi satu halaman search yang menggunakan AngularJS. Proses pencarian buku diambil dari webservice buku menggunakan **AJAX**. Hasil pencarian akan ditampilkan pada halaman search menggunakan AngularJS, setelah mendapatkan respon dari webservice. 

- Tampilan saat melakukan pencarian juga diubah untuk memberitahu jika aplikasi sedang melakukan pencarian atau tidak ditemukan hasil.

    Berikut adalah komponen pada AngularJS yang harus kami gunakan:
    - Data binding (ng-model directives)
    - Controllers (ng-controllers)
    - ng-repeat, untuk menampilkan list

- Aplikasi kami menggunakan `access token` untuk menentukan active user.

#### Mekanisme access token
`Access token` berupa string random. Ketika user melakukan login yang valid, sebuah access token di-generate, disimpan dalam database server, dan diberikan kepada browser. Satu `access token` memiliki `expiry time` token (berbeda dengan expiry time cookie) dan hanya dapat digunakan pada 1 *browser/agent* dari 1 *ip address* tempat melakukan login. Sebuah access token mewakilkan tepat 1 user. Sebuah access token dianggap valid jika:
- Access token terdapat pada database server dan dipasangkan dengan seorang user.
- Access token belum expired, yaitu expiry time access token masih lebih besar dari waktu sekarang.
- Access token digunakan oleh browser yang sesuai.
- Access token digunakan dari ip address yang sesuai.

Jika access token tidak ada atau tidak valid, maka aplikasi melakukan *redirect* ke halaman login jika user mengakses halaman selain login atau register. Jika access token ada dan valid, maka user akan di-*redirect* ke halaman search jika mengakses halaman login. Fitur logout akan menghapus access token dari browser dan dari server.

## Skenario

1. User melakukan registrasi dengan memasukkan informasi nomor kartu.
2. Jika nomor kartu tidak valid, registrasi ditolak dan user akan diminta memasukkan kembali nomor kartu yang valid.
3. User yang sudah teregistrasi dapat mengganti informasi nomor kartu.
4. Ketika user mengganti nomor kartu, nomor kartu yang baru akan diperiksa validasinya melalui webservice bank.
5. Setelah login, user dapat melakukan pencarian buku.
6. Pencarian buku akan mengirim request ke webservice buku. Halaman ini menggunakan AngularJS.
7. Pada halaman detail buku, ada rekomendasi buku yang didapat dari webservice buku. Rekomendasi buku berdasarkan kategori buku yang sedang dilihat.
8. Ketika user melakukan pemesanan buku, aplikasi akan melakukan request transfer kepada webservice bank.
9. Jika transfer berhasil, aplikasi mengirimkan request kepada webservice buku untuk mencatat penjualan buku.
10. Notifikasi muncul menandakan status pembelian, berhasil atau gagal.

## Struktur Basis Data

Pada tugas ini, kami menggunakan sistem manajemen basis data MySQL. Pada setiap tabel, atribut *primary key* ditandai dengan atribut yang ditebalkan.

### Basis Data pada Aplikasi *Bank Service*

Terdapat dua tabel pada basis data *bank service*, yakni tabel **customer** dan tabel **tx** (transaction)

#### Tabel Customer

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **id** | INT |
| name | CHAR(255) |
| balance | INT |

#### Tabel Transaction

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **sender_id** | INT |
| **receiver_id** | INT |
| **tx_time** | DATETIME |
| amount | INT |


### Basis Data pada Aplikasi *Book Service*

Terdapat dua tabel pada basis data *book service*, yakni tabel **book** dan tabel **book_category**

#### Tabel Book

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **id** | VARCHAR(15) |
| price | INT |
| sale | INT |

#### Tabel Book-Category

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **book_id** | VARCHAR(15) |
| **category** | VARCHAR(255) |


### Basis Data pada Aplikasi *ProBook*

Terdapat dua tabel pada basis data *ProBook*, yakni tabel **order**, tabel **review**, tabel **user**, dan tabel **active_token**

#### Tabel Order

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **order_id** | VARCHAR(15) |
| user_id | INT |
| book_id | INT |
| num_book | INT |
| order_date | DATE |

#### Tabel Review

| Atribut | Tipe Atribut |
|:-------:|----------------|
| ***order_id*** | INT |
| rating | INT |
| content | TEXT |

#### Tabel User

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **user_id** | INT |
| username | VARCHAR(20) |
| fullname | VARCHAR(140) |
| pass | VARCHAR(30) |
| prof_pic | TEXT |
| email | VARCHAR(100) |
| addrs | VARCHAR(100) |
| phone_num | VARCHAR(30) |
| stat | INT |

#### Tabel Active-Token

| Atribut | Tipe Atribut |
|:-------:|----------------|
| **token** | VARCHAR(32) |
| user_id | INT |
| user_agent | VARCHAR(255) |
| ip_address | VARCHAR(255) |
| expiry_time | DATETIME |







-------------------
## Konsep Shared Session

Shared session menggunakan **REST** kami implementasikan dengan memberikan token untuk tiap pengguna dari mengakses login atau register. Token yang diterima pengguna dapat diambil dan digunakan oleh pengguna lain (yang mengetahui token pengguna yang bersangkutan). Dengan token pengguna asli, pengguna lain bisa mempergunakan token tersebut untuk mendapat session yang sama di tempat yang berbeda.

## Token dan Expiry Time
Tiap pengguna yang masuk kami berikan token. Kami membangkitkan token dengan kombinasi 16 digit dari angka dan alfabet (A-Z,a-z,0-9). Saat logout, token akan dihapus. Untuk waktu, kami membatasi time out selama 1 menit.

## Kelebihan dan Kelemahan

Pada tugas kali ini kami memanfaatkan arsitektur yang berbeda dari aplikasi sebelumnya, dimana sebelumnya merupakan arsitektur monolitik yang menyatukan transaksi pembelian, pencarian, dan penyimpanan data buku di dalam satu aplikasi. Arsitektur yang kami gunakan sekarang memisah antara transaksi pembelian, pencarian, dan penyimpanan data buku dengan memanfaatkan webservice. Kami membuat dua webservice yaitu webservice bank dan webservice buku. Dengan memanfaatkan webservice seperti ini menjadikan aplikasi menjadi lebih modular. Sedangkan penerapan seperti ini menyebabkan pengimplementasian yang lebih kompleks.


## Pembagian Tugas
REST :
1. Validasi nomor kartu : 13516107
2. Transaksi : 13516086, 13516098

SOAP :
1. Search Book : 13516107
2. Get Book By Id : 13516098
3. Buy Book : 13516098
4. Retreive Google Book API : 13516086

Perubahan Web app :
1. Halaman Search :  13516086, 13516098
2. Halaman Profile : 13516086
3. Halaman Edit Profile :  13516086, 13516098
4. Halaman Register : 13516086, 13516098
5. Halaman Book Details : 13516098
6. Halaman History : 13516098

## About

Asisten IF3110 2018

Audry | Erick | Holy | Kevin J. | Tasya | Veren | Vincent H.

Dosen : Yudistira Dwi Wardhana | Riza Satria Perdana | Muhammad Zuhri Catur Candra

