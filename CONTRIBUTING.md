# Contributing to LaraGrape

Thank you for your interest in contributing to LaraGrape! 🎉

We welcome all contributions—whether you're fixing bugs, suggesting new features, improving documentation, or helping others.

## How to Contribute

### 1. Reporting Bugs
- Please [open an issue](https://github.com/streats22/laragrape/issues) with a clear description of the problem.
- Include steps to reproduce, expected behavior, and screenshots or error messages if possible.
- Mention your environment (OS, PHP/Laravel/Filament versions, etc.).

### 2. Suggesting Features
- [Open an issue](https://github.com/streats22/laragrape/issues) and label it as a feature request.
- Describe your idea, why it's useful, and any context or examples.

### 3. Submitting Pull Requests
- Fork the repository and create a new branch for your fix or feature.
- Make your changes, following our coding standards (see below).
- Add or update tests if relevant.
- Run the test suite to ensure everything passes.
- Submit a pull request with a clear description of your changes and why they're needed.

### 4. Coding Standards
- Follow PSR-12 for PHP code.
- Use meaningful variable and function names.
- Write clear, concise comments where needed.
- Keep code modular and DRY (Don't Repeat Yourself).
- For frontend code, follow the conventions in the existing files.

### 5. Running Tests
- Make sure you have all dependencies installed:
  ```sh
  composer install
  npm install
  ```
- Run PHP tests:
  ```sh
  ./vendor/bin/phpunit
  ```
- Run JS/CSS build (if needed):
  ```sh
  npm run build
  ```

### 6. Project Setup & Tips
- See `LARALGRAPE_SETUP.md` for setup instructions.
- Use the `test_laragrape_install.sh` script to test a fresh install.
- If you're adding or changing resources, make sure to follow the naming and namespace conventions described in the docs.
- If you have questions, open an issue or start a discussion!

---

We appreciate every contribution, big or small. Thank you for helping make LaraGrape better! 🍇 