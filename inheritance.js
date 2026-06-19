// ============================================
// CLASS INDUK (Parent / Superclass)
// ============================================
class Hewan {
  constructor(nama, suara) {
    this.nama = nama;
    this.suara = suara;
  }

  bersuara() {
    return `${this.nama} berbunyi: ${this.suara}`;
  }
}

// ============================================
// CLASS TURUNAN (Child / Subclass)
// "extends" artinya Kucing MEWARISI semua isi Hewan
// ============================================
class Kucing extends Hewan {
  constructor(nama) {
    super(nama, "Meong"); // panggil constructor milik Hewan
    this.jenis = "Kucing";
  }

  // method tambahan, HANYA dimiliki Kucing
  cakar() {
    return `${this.nama} mencakar!`;
  }
}

// Class turunan lain, untuk menunjukkan satu parent bisa punya banyak child
class Anjing extends Hewan {
  constructor(nama) {
    super(nama, "Guk guk");
    this.jenis = "Anjing";
  }

  kibasEkor() {
    return `${this.nama} mengibaskan ekornya!`;
  }
}

// ============================================
// PENGGUNAAN
// ============================================
const kucing1 = new Kucing("Mimi");
const anjing1 = new Anjing("Rex");

const hasil = [
  kucing1.bersuara(),   // method warisan dari Hewan
  kucing1.cakar(),       // method khusus Kucing
  anjing1.bersuara(),    // method warisan dari Hewan
  anjing1.kibasEkor(),   // method khusus Anjing
  `Apakah kucing1 instance dari Hewan? ${kucing1 instanceof Hewan}`,
];

// Tampilkan ke console
hasil.forEach(line => console.log(line));

