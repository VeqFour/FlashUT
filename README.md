# FlashUT

AI-powered flashcard platform for university students. Submit, review, and organize course flashcards with OpenAI-powered feedback and admin approval.  
Built with PHP, MySQL, and Tailwind CSS.

---

## 🚀 Features

- Student registration & login (for students only)
- Flashcard creation and submission per course/group
- AI-powered review and feedback using OpenAI GPT-4o
- Admin approval workflow for flashcards
- Course and group management
- Dashboards for students and admins
- Favorite/bookmark flashcards and groups
- Commenting and contribution tracking
- Responsive design for all devices

---

## 🛠️ Tech Stack

- **Backend:** PHP 8+, MySQL
- **Frontend:** HTML, JavaScript, CSS
- **AI:** OpenAI GPT-4o API

---

## ⚡ Quickstart

1. **Clone the repository:**
    ```bash
    git clone git@github.com:VeqFour/FlashUT.git
    cd FlashUT
    ```

2. **Install PHP dependencies:**
    ```bash
    composer install
    ```

3. **Set up environment variables:**
    - Copy the example file:
      ```bash
      cp config/.env.example config/.env
      ```
    - Add your OpenAI API key to `config/.env`:
      ```
      OPENAI_API_KEY=your-openai-key-here
      ```

4. **Database setup:**  
    - **Import `CFCWA.sql` into your MySQL server** to create all necessary tables.  
    - (Optional) The file may include sample/demo data for testing.
    - Update your `includes/db.php` file with your own database credentials.

5. **Run locally:**  
   Start XAMPP/MAMP and go to:



   ---

## User Roles and Login

- **Registration is for students only.**
- To create an admin or superadmin account, **edit the `user` table directly in your MySQL database** and set the `role` field.
 ```sql
 UPDATE user SET role = 'admin' WHERE username = 'your_admin_username';
 ```
- Superadmin permissions and rules are managed the same way.

*There is no public admin registration form.*

---

## Database Setup

- Import `flashut_schema.sql` into your MySQL server to create all necessary tables.
- (Optional) The file may include sample/demo data for testing.
- Update your `includes/db.php` file with your own database credentials.

**You must have a running MySQL/MariaDB server.**

---

## Environment Variables

All secrets go in `config/.env` (never commit secrets!).

Example (`config/.env.example`):



---

## Project Structure

FlashUT/
│
├── config/             # .env and environment files
├── controllers/        # PHP controllers for API/actions
├── includes/           # DB connection, helper includes
├── partials/           # Reusable UI/logic components
├── superAdmin/         # Super admin tools and actions
├── template/           # CSS, images, frontend assets
├── views/              # Page templates (admin/student)
├── composer.json       # PHP dependencies
├── flashut_schema.sql  # Database structure (import this first)
└── README.md           # This file




---

## Security

- **Never commit real API keys or passwords.**
- Before pushing, always run:  
    ```bash
    grep 'sk-' -r .
    ```
- `.env` files are in `.gitignore` and must NOT be pushed.

---

## Contributing

Pull requests and suggestions are welcome!  
Open an issue or contact the maintainer if you want to help.

---

## License

Specify your license here (MIT, Apache 2.0, etc) or state proprietary.

---

## Contact

Abdullah alamri  
[GitHub Profile](https://github.com/VeqFour)

---