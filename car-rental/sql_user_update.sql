-- Eğer users tablosunda is_admin sütunu yoksa ekleyin
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_admin BOOLEAN DEFAULT FALSE;

-- İlk kullanıcıyı admin yap (id=1 olan kullanıcı)
UPDATE users SET is_admin = TRUE WHERE id = 1;

-- Diğer kullanıcıları da admin yapmak için (istediğiniz id'yi yazabilirsiniz)
-- UPDATE users SET is_admin = TRUE WHERE id = 2; 