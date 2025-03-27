## Installation
1. Download and install Herd: https://herd.laravel.com/windows
2. Download and install nodejs: https://nodejs.org/en/download/prebuilt-installer
3. Go to Code button --> Download ZIP --> Unzip the downloaded archive

<img width="939" alt="Screenshot 2024-11-22 at 10 25 48" src="https://github.com/user-attachments/assets/4a0528c5-6068-41d8-b261-35ca4d2d6235">

4. Open the code folder with VS Code

5. Create `.env` file, copy `.env.example` to `.env` and fill in `.env` file as follows:

    <img width="398" alt="Screenshot 2024-11-22 at 10 30 48" src="https://github.com/user-attachments/assets/e975388c-8b16-487d-b27e-d559a554cb3e">

- Enter database password (if any)

    <img width="344" alt="Screenshot 2024-11-27 at 14 11 26" src="https://github.com/user-attachments/assets/dcfb3e2c-fb2c-4f5a-9bee-7c2b3b31a6f4">

- Enter email address and password, get from gmail setting. Follow this instruction for more information: https://www.codersvibe.com/how-to-send-email-with-gmail-smtp-in-laravel.   
    _**Note: only do step 2, 3, 4**_

    ![image](https://github.com/user-attachments/assets/8373141f-95de-4b7a-8616-8770845189ed)

6. Open your terminal and run `composer install` (Press Ctrl + J to open terminal in VS Code)

    <img width="1728" alt="Screenshot 2024-11-22 at 10 32 26" src="https://github.com/user-attachments/assets/1394153c-bc57-453b-9ca6-bbd1f895aa29">

7. Run `php artisan key:generate`
8. Run `php artisan migrate --seed` to create the database tables and seed the roles and users tables
9. Run `php artisan serve` 
10. Open another terminal and run `npm install`, then run `npm run dev`

<img width="1728" alt="Screenshot 2024-11-22 at 10 35 21" src="https://github.com/user-attachments/assets/ce9ca9b1-7074-40b9-a0b6-ac69383dfe99">

11. Go to http://127.0.0.1:8000/

### Admin account:
- Email: admin@gmail.com
- Password: 123456
