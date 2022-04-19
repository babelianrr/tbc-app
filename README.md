# The Babelian Channel
The initial release of The Babelian Channel Official Website.

## Getting started
- Clone the repository to your machine.
- Import `tbc.sql` to phpMyAdmin.
- Run the app using XAMPP/MAMPP/LAMPP on `localhost`.
- Don't forget to configure database on `application/config/config.php`.
- Admin's credential:
  ```
  "email": "admin@tbc.net",
  "password": "admin123"
  ```
- Configure mail verification feature on `application/controllers/Auth.php`
  - To use your gmail for smtp verification, configure your google account and enable insecure apps.
  ```
  ...
  'smtp_user' => '', // use your gmail address
  'smtp_pass' => '', // use your gmail password
  ...

  $this->email->from('', ''); // use which email address to send the email from & the alias
  ...
  ```

## Key Features:
- Register with email verification.
- Forget password with email verification.
- User role access management.
- Menu management.

## Website-Only Features:
- Looking at Modoo Marble Items Directory.

Visit [here](https://thebabelianchannel.site) to check the website-only features.

## Upcoming Features:
- Blog post that only allow admins to write and everybody can read.

## Known bugs
- When updating role or menu management, sidebar might stay inactive when navigating. To solve this, simply edit corresponding method in the controller. Rename the title with same name as updated name.
