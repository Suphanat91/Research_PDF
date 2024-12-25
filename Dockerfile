# ใช้ PHP Official Image พร้อม Apache
FROM php:8.1-apache

# ติดตั้ง Composer และไลบรารีที่จำเป็น
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    default-mysql-client \
    default-libmysqlclient-dev \
    && docker-php-ext-install zip pdo pdo_mysql mysqli

# ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# เปิดใช้งานโมดูล Apache
RUN a2enmod rewrite

# กำหนด Working Directory ใน Container เป็นโฟลเดอร์ src
WORKDIR /var/www/html

# คัดลอกไฟล์ทั้งหมดจากโฟลเดอร์ src ไปยัง /var/www/html
COPY ./src /var/www/html

# ตั้งสิทธิ์ไฟล์
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# ติดตั้ง Dependencies ผ่าน Composer
RUN composer install --working-dir=/var/www/html

# เปิดพอร์ต 80
EXPOSE 80

CMD ["apache2-foreground"]