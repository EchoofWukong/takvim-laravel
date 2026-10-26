# 📅 Akıllı Eğitim Takvimi (Web Versiyonu)

Laravel kullanılarak üniversiteler, fakülte yönetimleri ve hocalar için geliştirilmiş kapsamlı web tabanlı akademik planlama ve sınıf/öğrenci otomasyon sistemidir. 

## 🌟 Özellikler

- **Gelişmiş Takvim Yönetimi:** Etkileşimli web takvimi üzerinden ders programları, sınav tarihleri ve etkinliklerin kolayca planlanıp takip edilmesi.
- **Sınıf ve Amfi Durumu:** Hangi dersliğin hangi saatlerde boş veya dolu olduğunun anlık olarak sistem üzerinden izlenmesi.
- **Öğrenci - Masa Atama Sistemi:** Dersliklerin yerleşim planlarının oluşturulması ve öğrencilerin hangi masalarda oturacağının detaylı olarak haritalanması.
- **Kullanıcı Yetkilendirme (Rol Yönetimi):** Yönetim, Akademisyen ve Öğrenci gibi farklı kullanıcı rolleriyle sisteme güvenli giriş ve yetki bazlı erişim.
- **Modern ve Duyarlı Arayüz:** Laravel Blade ile geliştirilmiş, tüm cihazlarda (mobil, tablet, masaüstü) sorunsuz çalışan kullanıcı dostu tasarım.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** Laravel (PHP)
- **Frontend:** Laravel Blade, HTML5/CSS3, JavaScript
- **Veritabanı:** MySQL / PostgreSQL
- **Mimari:** MVC (Model-View-Controller)

## ⚙️ Kurulum ve Çalıştırma (Yerel Ortam)

Projeyi bilgisayarınızda çalıştırmak için aşağıdaki komutları tek seferde kopyalayıp terminalinizde çalıştırın:

```bash
git clone [https://github.com/EchoofWukong/akilli-egitim-takvimi-laravel.git](https://github.com/EchoofWukong/akilli-egitim-takvimi-laravel.git)
cd akilli-egitim-takvimi-laravel
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
