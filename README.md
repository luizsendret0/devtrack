## Documentation

Detailed technical documentation is available in the
[docs directory](.app/docs/README.md).

**Track your applications. Develop your skills. Build your career.**

DevTrack is a web application designed to help students and junior developers organize their job applications, monitor recruitment processes, and identify the technical skills they should prioritize based on job requirements.

**Current version:** `v0.2.0-alpha`  
**Project status:** In Development  
**Development approach:** PHP without frameworks, using a simplified MVC architecture.

---

## About the Project

Finding the first opportunity in tech can be challenging.

Job applications are often spread across multiple platforms, making it difficult to track application statuses, organize interviews, and identify which technologies are most frequently requested by employers.

DevTrack aims to solve these problems by combining two main features:

- **Application Tracking:** Manage job opportunities and follow each stage of the recruitment process.
- **Learning Management:** Identify skill gaps and organize learning paths based on technologies required in saved job opportunities.

The goal is to connect job searching with professional development in a single platform.

## Current Features

The following features are implemented in the current prototype:

- [x] Initial project structure
- [x] Dashboard interface
- [x] Sidebar navigation
- [x] Application Kanban interface using sample data
- [x] Learning section interface
- [x] Light and dark themes
- [x] Theme preference persistence
- [x] Glassmorphism visual effects
- [x] Responsive layout styling
- [ ] User registration and authentication
- [ ] Database-backed application management
- [ ] Functional Kanban status management
- [ ] Dynamic dashboard statistics
- [ ] Job-based technology analysis
- [ ] Personalized learning recommendations

**Note:** The dashboard currently displays demonstration data. Authentication, application persistence, and learning recommendations are not yet functional.

## Technologies

| Category | Technology |
|---|---|
| Front-end | HTML5, CSS3, JavaScript |
| Back-end | PHP |
| Database | MySQL |
| Database Access | PDO |
| Architecture | Simplified MVC |
| Local Development | Laragon |
| Version Control | Git & GitHub |

Additional technologies may be introduced as the project evolves.

## Project Structure

```text
devtrack/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── config/
│   └── middleware/
├── database/
│   └── schema.sql
├── docs/
│   ├── README.md
│   ├── escopo.md
│   ├── requisitos-funcionais.md
│   ├── requisitos-nao-funcionais.md
│   ├── regras-de-negocio.md
│   └── modelo-de-dados.md
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── index.php
├── views/
│   ├── auth/
│   ├── dashboard/
│   ├── jobs/
│   ├── layouts/
│   └── shared/
├── .gitignore
└── README.md
```

## Documentation

The project documentation is organized in the `docs/` directory.

It includes:

- Project scope and objectives
- Functional requirements (RF)
- Non-functional requirements (RNF)
- Business rules (RN)
- Data model planning

These documents describe the intended system behavior and will be updated throughout development.

## Development Roadmap

| Version | Milestone | Status |
|---|---|---|
| v0.1.0 | Project setup and initial structure | Completed |
| v0.2.0-alpha | Dashboard UI, navigation and theme system | Current |
| v0.3.0-alpha | User authentication and session management | Planned |
| v0.4.0-alpha | Job application CRUD | Planned |
| v0.5.0-beta | Dynamic dashboard and Kanban | Planned |
| v0.6.0-beta | Skill analysis and learning recommendations | Planned |
| v1.0.0 | Complete and tested MVP | Planned |

## Running Locally

The project is currently developed using Laragon on Windows.

1. Clone the repository into your local development directory.
2. Start Apache and MySQL in Laragon.
3. Configure the local virtual host to use the `public/` directory as the document root.
4. Open the application using the configured local domain, such as `http://devtrack.test`.

Database configuration and installation instructions will be expanded as the back-end is implemented.

## Project Goals

This project is also part of my personal development as a software developer.

Through DevTrack, I aim to improve my knowledge of:

- PHP and object-oriented programming
- MVC architecture
- Relational database modeling
- SQL queries and PDO
- Authentication and web security
- Responsive interface development
- Software documentation and testing

## Author

**Luiz Felipe Sendreto**

Systems Development Student

[GitHub](https://github.com/luizsendret0)

---

*DevTrack is an independent personal project currently under active development.*