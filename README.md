# MathBridge EdTech

**MathBridge EdTech** is an open-source academic research and development project focused on building a lightweight digital educational ecosystem for teaching mathematics and other STEM disciplines.

The project integrates a Learning Management System (LMS) with interactive computational environments, providing students with a unified access point for computational tools used in mathematical and engineering education.

The current implementation integrates **ATutor LMS** with **JupyterHub** using a lightweight JWT-based Single Sign-On (SSO) mechanism and Docker-based user isolation.

---

## Project Status

MathBridge is an **active academic research and development project**.

The current repository contains a working prototype of the ATutor–JupyterHub integration based on JWT-based Single Sign-On (SSO).

The prototype has been deployed and experimentally evaluated in an academic environment. The current implementation demonstrates the feasibility of integrating an LMS with a multi-user interactive computational environment without requiring an external identity provider.

The next development phase focuses on cloud deployment and a broader educational pilot involving engineering students at **Ternopil National Technical University (TNTU), Ukraine**.

The project is currently under active development.

---

## Research Context

MathBridge is developed in the context of research on lightweight integration of Learning Management Systems with interactive computational environments for STEM education.

The current implementation is described and evaluated in the research article:

> **ATutor–JupyterHub Integration: A JWT-Based SSO Approach**

The repository contains software artifacts associated with the implementation described in the research.

Additional experimental, deployment, and reproducibility artifacts will be added as the research project progresses.

---

## Motivation

Modern STEM education increasingly requires access to interactive computational environments for programming, numerical analysis, symbolic mathematics, and data science.

However, integrating such environments with existing LMS platforms can introduce additional authentication mechanisms, administrative complexity, and infrastructure requirements.

MathBridge investigates a lightweight approach in which an existing LMS serves as the primary educational entry point while JupyterHub provides an interactive computational environment.

The goal is to create a unified educational workflow in which students can move from the LMS to their computational environment without performing a separate login.

The project is particularly focused on educational institutions with limited infrastructure and administrative resources, where large-scale cloud-native architectures may be unnecessarily complex for the expected workload.

---

## Current Architecture

The current prototype uses the following architecture:

```text
                    MathBridge EdTech
                           │
                           ▼
                    ┌─────────────┐
                    │   ATutor    │
                    │     LMS     │
                    └──────┬──────┘
                           │
                     JWT / HS256
                           │
                           ▼
                  ┌──────────────────┐
                  │    JupyterHub    │
                  │ JWT Authenticator│
                  └────────┬─────────┘
                           │
                    DockerSpawner
                           │
              ┌────────────┴────────────┐
              │                         │
              ▼                         ▼
        User container            User container
              │                         │
              ▼                         ▼
        Computational            Computational
         environment              environment
```

The current architecture is intentionally lightweight and is designed for academic groups of moderate size.

---

## Main Components

### ATutor LMS

ATutor is used as the primary Learning Management System and educational entry point.

A custom ATutor module provides:

- integration with JupyterHub;
- authentication-session verification;
- JWT generation;
- automatic redirection to JupyterHub;
- module installation through the ATutor administration interface;
- module uninstallation through the ATutor administration interface.

### JWT-Based Single Sign-On

The integration uses **JSON Web Tokens (JWT)** signed using **HMAC-SHA256 (HS256)**.

The authentication flow is:

```text
Student
   │
   ▼
ATutor login
   │
   ▼
Authenticated ATutor session
   │
   ▼
JWT generation
   │
   ▼
Redirect to JupyterHub
   │
   ▼
JWT validation
   │
   ▼
JupyterHub session
```

The JWT contains the user identity and time-related claims used to limit token validity.

No external OAuth2/OpenID Connect identity provider is required by the current prototype.

### JupyterHub

JupyterHub provides the multi-user interactive computational environment.

A custom JWT authenticator validates the token generated by ATutor and establishes the JupyterHub user session.

### DockerSpawner

DockerSpawner is used to provide isolated computational environments for individual users.

This approach allows user environments to be separated while using a common server infrastructure.

---

## Security Considerations

The current prototype uses a shared secret for JWT signing and verification.

The same shared secret must be configured independently on both the ATutor and JupyterHub sides.

**The actual secret must never be committed to the public repository.**

Configuration files included in the repository contain placeholders rather than production credentials or secret keys.

The current experimental deployment uses an HTTP endpoint within an isolated experimental environment.

For production or deployment over an untrusted network, the JupyterHub endpoint should be protected using **HTTPS/TLS**.

The JWT lifetime is intentionally limited in order to reduce the exposure window of a token if it is intercepted.

---

## Repository Structure

The current repository is organized around the main software components of the prototype:

```text
mathbridge/
├── index.html
├── README.md
├── LICENSE
├── CITATION.cff
├── CONTRIBUTING.md
├── CODE_OF_CONDUCT.md
├── .gitignore
├── atutor/
│   └── jupyter_auth/
│       ├── include/
│       ├── pages/
│       ├── module.xml
│       ├── module.sql
│       └── ...
└── jupyterhub/
    └── authenticator/
        ├── 20-jwt-auth.py
        └── README.md
```

The repository structure will be extended as additional experimental and reproducibility artifacts are prepared.

---

## Installation Overview

The current prototype requires:

- ATutor LMS;
- JupyterHub;
- Python environment compatible with the JupyterHub installation;
- PyJWT;
- Docker;
- DockerSpawner;
- a shared JWT secret configured independently on both systems.

The general deployment sequence is:

```text
1. Install and configure ATutor
2. Install and configure JupyterHub
3. Install Docker and DockerSpawner
4. Install the custom ATutor JWT module
5. Configure the JupyterHub JWT authenticator
6. Configure the same shared JWT secret on both sides
7. Configure the JupyterHub URL in ATutor
8. Restart the relevant services
9. Test the SSO workflow
```

Detailed installation and configuration instructions are provided in the component-specific documentation.

---

## ATutor Module

The ATutor component is located in:

```text
atutor/jupyter_auth/
```

The module provides the integration point between ATutor and JupyterHub.

The module can be installed and removed using the standard ATutor administration mechanisms.

The implementation separates:

- configuration;
- JWT generation;
- redirection;
- module lifecycle operations.

---

## JupyterHub Authentication

The JupyterHub authentication component is located in:

```text
jupyterhub/authenticator/
```

The custom authenticator:

1. receives the JWT;
2. validates the token signature;
3. validates the token claims;
4. extracts the username;
5. establishes the corresponding JupyterHub user session.

The implementation currently uses the HS256 signing algorithm.

---

## Experimental Background

The current implementation was experimentally evaluated in an academic environment at **Ternopil National Technical University (TNTU)**.

The experimental deployment was based on a virtual machine with:

- 4 CPU cores;
- Intel(R) Core(TM) i5-7400 processor;
- 4 GB RAM;
- 30 GB SSD storage.

The system was used in the context of mathematics education and evaluated with small academic groups.

The initial experimental study focused on the authentication and environment-access process, including the difference between:

- **cold start** — initialization of a new user environment;
- **warm start** — access to an already initialized environment.

The results indicated that the main source of access-time variation was the initialization of the computational environment rather than the JWT-based authentication procedure.

A broader experimental evaluation is planned as the next stage of the project.

---

## Planned Cloud Deployment

The next phase of MathBridge is planned as a **cloud-based educational pilot** at Ternopil National Technical University.

The purpose of the cloud deployment is to extend the existing local prototype and evaluate the architecture under a larger real-world educational workload.

The planned study will involve approximately **50 engineering students** and will investigate:

- concurrent student access;
- JupyterHub container startup performance;
- cold and warm start behavior;
- resource utilization;
- system stability under educational workloads;
- scalability limits of the selected single-node architecture;
- practical usability in the educational process.

The cloud deployment is intended to provide a substantially broader experimental basis for evaluating the proposed architecture.

---

## Roadmap

### Completed

- [x] Initial MathBridge project definition
- [x] ATutor–JupyterHub integration
- [x] JWT-based Single Sign-On
- [x] Custom JupyterHub JWT authentication
- [x] Docker-based user isolation
- [x] ATutor module installation/uninstallation support
- [x] Local experimental deployment
- [x] Initial performance evaluation
- [x] Public GitHub repository
- [x] Project documentation
- [x] Initial research software artifact publication

### Planned

- [ ] Cloud deployment
- [ ] Extended educational pilot
- [ ] Evaluation with approximately 50 engineering students
- [ ] Concurrent-load experiments
- [ ] Resource utilization analysis
- [ ] Extended cold/warm start analysis
- [ ] Scalability evaluation
- [ ] Publication of anonymized experimental data
- [ ] Publication of log-analysis and statistical-analysis tools
- [ ] Additional reproducibility artifacts
- [ ] Research software release
- [ ] Zenodo archival and DOI assignment

---

## Research and Educational Objectives

The project investigates whether a lightweight integration architecture can provide practical access to interactive computational environments while maintaining:

- low administrative complexity;
- reasonable resource requirements;
- user isolation;
- reproducible computational environments;
- seamless authentication;
- suitability for small and medium-sized academic groups.

The broader objective is to contribute to the development of an integrated open-source educational ecosystem for teaching mathematics and engineering disciplines.

---

## Open Source

MathBridge is developed using open-source software and is intended to provide a reproducible and adaptable foundation for educational institutions.

The project does not depend on proprietary LMS or computational-environment components for its core integration mechanism.

The use of open-source technologies is intended to support technological independence and reduce infrastructure barriers for educational institutions.

---

## Limitations

The current implementation and experimental evaluation have several limitations:

- the initial evaluation was conducted on a single virtual machine;
- the available computational resources were limited;
- the initial academic groups were relatively small;
- large-scale concurrent-load testing has not yet been performed;
- the current deployment does not represent a highly available production infrastructure;
- the broader cloud-based evaluation remains future work.

These limitations define the motivation for the next stage of the project.

---

## Relation to the Research Project

MathBridge is part of an ongoing research effort to develop practical digital educational ecosystems based on open-source technologies.

The current ATutor–JupyterHub integration represents one stage of this research and focuses specifically on authentication and access integration between the LMS and the computational environment.

The planned cloud deployment will extend the research from a local proof-of-concept and initial educational evaluation toward a broader real-world experimental study.

---

## Citation

If you use the MathBridge software or the ATutor–JupyterHub integration in academic work, please cite the associated research publication.

Citation metadata are provided in:

```text
CITATION.cff
```

A persistent archival DOI will be added after the research artifact reaches its final release stage.

---

## Contributing

Contributions, suggestions, and feedback are welcome.

Please see:

```text
CONTRIBUTING.md
```

for contribution guidelines.

---

## License

MathBridge is distributed under the **MIT License**.

See:

```text
LICENSE
```

for the complete license text.

---

## Contact

**Hryhorii Habrusiev**  
Ternopil Ivan Puluj National Technical University  
Ternopil, Ukraine

The project is developed for academic research and educational purposes.