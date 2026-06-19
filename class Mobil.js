class Mobil {
  // constructor dijalankan otomatis saat object baru dibuat
  constructor(merk, warna, kecepatan) {
    this.merk = merk;
    this.warna = warna;
    this.kecepatan = kecepatan;
  }

  // method: aksi yang bisa dilakukan object
  jalan() {
    console.log(`${this.merk} berjalan dengan kecepatan ${this.kecepatan} km/jam`);
  }

  berhenti() {
    this.kecepatan = 0;
    console.log(`${this.merk} berhenti`);
  }

  info() {
    console.log(`Mobil ${this.merk} berwarna ${this.warna}`);
  }
}

// membuat object baru dari class Mobil
const mobil1 = new Mobil("Avanza", "Hitam", 80);
const mobil2 = new Mobil("Brio", "Putih", 100);

mobil1.info();    // "Mobil Avanza berwarna Hitam"
mobil1.jalan();    // "Avanza berjalan dengan kecepatan 80 km/jam"
mobil1.berhenti(); // "Avanza berhenti"

mobil2.info();    // "Mobil Brio berwarna Putih"
mobil2.jalan();    // "Brio berjalan dengan kecepatan 100 km/jam"