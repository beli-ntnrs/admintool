# Admin Tool - Claude Code Setup

**App Name:** Admin Tool (admintool)
**Type:** Internal application
**Tech Stack:** PHP 8.1+, Slim Framework, Bootstrap 5, SQLite

---

## App Overview

Main admin dashboard for Notioneers. Used for:
- User management
- System configuration
- Analytics and reporting
- Content moderation

---

## Folder Structure

```
admintool/
├── CLAUDE.md              ← You are here
├── README.md
├── src/
│   ├── Controllers/       ← HTTP handlers
│   ├── Models/            ← Database models
│   ├── Services/          ← Business logic
│   ├── Middleware/        ← Request handlers
│   └── Views/             ← HTML templates
├── tests/
│   ├── Unit/              ← Function tests
│   └── Integration/       ← Database + API tests
└── public/
    └── index.php          ← Entry point
```

---

## How to Use Claude Code for This App

### Planning a Feature
```
Use: /plan-feature "I want to add user export to CSV"

Architect will:
- Ask about format, frequency, scope
- Propose solution using current stack
- Create implementation plan
```

### Found a Bug?
```
Use: /debug-issue "Error: SMTP failed on line 245 in MailService.php"

Debugger will:
- Create test that reproduces bug
- Show test FAILS (proves bug exists)
- Point to root cause
```

### Ready to Review Code?
```
Existing code will be reviewed by:
- code-reviewer: Quality & bugs
- security-specialist: Security vulnerabilities
- tester: Test coverage
- ui-specialist: UI/Design compliance
```

---

## Common Tasks

### Create New Feature
1. `/plan-feature "description"`  →  Get approval
2. Write tests (TDD)
3. Implement code
4. All tests pass
5. Review code
6. Commit & push

### Fix a Bug
1. `/debug-issue "error description"`  →  Find root cause
2. Write test that reproduces bug
3. Fix the code
4. Test passes
5. Verify other tests still pass
6. Commit & push

### Run Tests
```bash
composer test                    # All tests
./vendor/bin/phpunit tests/Unit/ # Unit only
```

---

## App-Specific Notes

### Database
- Uses SQLite (see ../dev.db)
- Migrations not used (SQL is directly in db)
- In tests: in-memory database automatically

### Authentication
- Session-based (stored in $_SESSION)
- Middleware checks for auth on all routes
- CSRF tokens on all forms

### Frontend
- Bootstrap 5 grid system
- No JS frameworks (vanilla JS only)
- Responsive design (mobile-first)
- Design system colors from /shared/design-system/

### Performance
- No complex queries (SQLite limitation)
- No N+1 queries
- Pagination for large result sets

---

## Important Files

| File | Purpose |
|------|---------|
| `src/Controllers/` | Handles HTTP requests |
| `src/Models/` | Database representation |
| `src/Services/` | Business logic |
| `src/Views/` | HTML templates (Bootstrap) |
| `tests/Unit/` | Function tests |
| `tests/Integration/` | Feature tests with DB |

---

## Reference to Global CLAUDE.md

For overall project guidelines, see: `/Users/beli/Development/CLAUDE.md`

This includes:
- Global workflow (Plan → Code → Review → Commit)
- Debugging workflow
- Security standards
- Testing standards
- Git workflow

---

## Need Help?

Refer to:
- **Planning:** Agent: architect.md
- **Debugging:** Agent: debugger.md (with /debug-issue command)
- **Code Quality:** Agent: code-reviewer.md
- **Security:** Agent: security-specialist.md
- **Testing:** Agent: tester.md
- **UI/Design:** Agent: ui-specialist.md
- **Docs:** Agent: documentation.md

---

Happy coding! 🚀
