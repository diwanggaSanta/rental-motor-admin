# Menggunakan image resmi PHP 8.2 dengan server Apache
FROM php:8.2-apache

# Menginstall ekstensi sistem yang dibutuhkan (termasuk untuk PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git

# Membersihkan cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Menginstall ekstensi PHP untuk Laravel dan PostgreSQL (Supabase)
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Mengaktifkan modul Apache Rewrite (Wajib untuk routing Laravel)
RUN a2enmod rewrite

# Mengarahkan domain utama ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Menginstall Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menentukan lokasi kerja di dalam server
WORKDIR /var/www/html

# Menyalin seluruh kode proyek Laravel-mu ke dalam server
COPY . .

# Menjalankan instalasi dependency Laravel
RUN composer install --optimize-autoloader --no-dev

# Memberikan izin akses folder agar Laravel bisa menyimpan cache & foto
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache