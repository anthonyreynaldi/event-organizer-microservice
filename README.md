# Event Organizer Microservices Project
Project UAS Service Oriented Architecture / Arsitektur Berorientasi Layanan

### Kelompok 8:
1. C14200007 - Xuchin Valezka
2. C14200078 - Anthony Reynaldi
3. C14200094 - Steven Christando


## List Service
- Client Management Service - :5500/client
- Staff Management Service - :5501/staff
- Login Service - :5502/login
- Event Service - :5503/event
- Order Service - :5504/order

## Diagram
<img src="./diagram.png" style="display: inline-block; margin: 0 auto; max-width: 40vw">

## UI
### User Login
#### As Client
Masuk sebagai client dengan input username dan juga password.
<img src="./z-ui/Client%20Login.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### As Staff
Masuk sebagai staff dengan input username dan juga password.
<img src="./z-ui/Staff%20Login.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Register as Client
Tampilan ketika akan mendaftar sebagai client baru. Diminta untuk memasukkan data baru seperti nama, nomor telepon, username, dan password.
<img src="./z-ui/Register%20as%20Client.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

### Client Side
Tampilan dari sisi client.
#### Edit Profile
Client dapat mengubah data dirinya dengan menu edit profile.
<img src="./z-ui/Client%20Edit%20Profile.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Homepage
Tampilan awal setelah client login, akan ditampilkan list order dari client apabila client sudah melakukan order.
<img src="./z-ui/Client%20Homepage.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Client Make Order
Tampilan ketika client akan membuat pesanan. Client dapat memasukkan tanggal acara, memberi catatan, dan juga memilih paket acara yang diinginkan.
<img src="./z-ui/Client%20Make%20Order.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Order Details
Tampilan ketika ingin melihat detil dari salah satu order. Akan ada detil acaranya beserta dengan detil rangkaian acaranya.
<img src="./z-ui/Client%20Order%20Details.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

### Staff Side
Tampilan dari sisi staff.
#### Edit Profile
Staff dapat mengubah data dirinya dengan menu edit profile.
<img src="./z-ui/Staff%20Edit%20Profile.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Homepage
Tampilan awal setelah staff login, akan ditampilkan list order dari client.
<img src="./z-ui/Staff%20Homepage.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Order Details
Tampilan ketika ingin melihat detil dari salah satu order. Akan ada detil acaranya beserta dengan detil rangkaian acaranya.
<img src="./z-ui/Staff%20Order%20Detail.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

##### Add Event
Setelah membuka detil order, staff yang bertanggung jawab (PIC) dapat menambahkan event (rangkaian acara) untuk acara tersebut.
<img src="./z-ui/Staff%20Add%20Event.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">

#### Add New Staff
Staff dapat menambahkan data untuk staff baru.
<img src="./z-ui/Staff%20Add%20New%20Staff.jpg" style="display: inline-block; margin: 0 auto; max-width: 40vw">