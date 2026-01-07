import express from "express";
import multer from "multer";
import cors from "cors";

const app = express();
app.use(cors()); // biar bisa diakses dari browser

// Konfigurasi penyimpanan file
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "uploads/");
  },
  filename: (req, file, cb) => {
    cb(null, Date.now() + "-" + file.originalname);
  }
});

const upload = multer({ storage });

// Endpoint upload
app.post("/upload", upload.single("file"), (req, res) => {
  res.send(`Upload berhasil! File disimpan di /uploads/${req.file.filename}`);
});

// Jalankan server
app.listen(3000, () => console.log("Server berjalan di http://localhost:3000"));