-- Fix Medical Records dengan patient_id NULL
-- Assign ke patient pertama yang ada (atau sesuaikan manual)

-- Check berapa record yang patient_id NULL
SELECT COUNT(*) as total_null
FROM medical_records
WHERE
    patient_id IS NULL;

-- Lihat patient ID yang tersedia
SELECT id, nama_lengkap, email FROM patients ORDER BY id;

-- UPDATE: Assign semua record NULL ke patient tertentu
-- GANTI '1' dengan patient_id yang sebenarnya!
-- Contoh: Kalau test@gmail.com patient_id = 29, gunakan 29

UPDATE medical_records
SET
    patient_id = 29 -- ✅ GANTI 29 dengan patient_id yang benar!
WHERE
    patient_id IS NULL;

-- Verify hasil update
SELECT
    id,
    no_rm,
    patient_id,
    tanggal_masuk,
    keluhan
FROM medical_records
ORDER BY id DESC
LIMIT 10;