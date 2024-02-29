import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostProvider } from '../../providers/post-provider';
@Component({
 selector: 'app-tab2',
 templateUrl: 'tab2.page.html',
 styleUrls: ['tab2.page.scss']
})
export class Tab2Page implements OnInit {
 pilih: string = '';
 id_game: string = '';
 nama: string = '';
 email: string = '';
 nohp: string = '';
 nominal: string = '';
 metode: string = '';
 constructor(
 private router: Router,
 public toastController: ToastController,
 private postPvdr: PostProvider,
 ) { 
 
 }
 ngOnInit() {
 }
 async addRegister() {
 if (this.pilih == '') {
 const toast = await this.toastController.create({
 message: 'Pilih game terlebih dahulu',
 duration: 2000
 });
 toast.present();
 } else if (this.id_game == '') {
 const toast = await this.toastController.create({
 message: 'Id Game harus di isi',
 duration: 2000
 });
 toast.present();
 } else if (this.nama == '') {
 const toast = await this.toastController.create({
  message: 'Nama user harus di isi',
  duration: 2000
  });
  toast.present();
  } else if (this.email == '') {
  const toast = await this.toastController.create({
  message: 'Email harus di isi',
  duration: 2000
  });
  toast.present();
} else if (this.nohp == '') {
  const toast = await this.toastController.create({
  message: 'No HP harus di isi',
  duration: 2000
  });
  toast.present();
} else if (this.nominal == '') {
  const toast = await this.toastController.create({
  message: 'Jumlah top up harus di isi',
  duration: 2000
  });
  toast.present();
} else if (this.metode == '') {
  const toast = await this.toastController.create({
  message: 'Metode Pembayaran harus di isi',
  duration: 2000
  });
  toast.present();
  } else {
  let body = {
  pilih: this.pilih,
  id_game: this.id_game,
  nama: this.nama,
  email: this.email,
  nohp: this.nohp,
  nominal: this.nominal,
  metode: this.metode,
  aksi: 'add_register'
  };
  this.postPvdr.postData(body, 'action.php').subscribe(async data => {
  var alertpesan = data.msg;
  if (data.success) {
  this.router.navigate(['/tab3']);
  const toast = await this.toastController.create({
  message: 'Selamat! Top Up Game Berhasil !.',
  duration: 2000
  });
  toast.present();
  } else {
  const toast = await this.toastController.create({
  message: alertpesan,
  duration: 2000
  });
  }
  });
  }
  }
 }