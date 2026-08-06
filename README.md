\# MathBridge EdTech



\### Open Educational Ecosystem for Mathematical Computing





\*\*MathBridge EdTech\*\* is an open-source educational ecosystem designed to integrate a Learning Management System (ATutor) with interactive computational environments based on JupyterHub and SageMath through a lightweight JSON Web Token (JWT) Single Sign-On (SSO) mechanism.



The project aims to provide engineering students with seamless access to mathematical computing tools directly from the LMS while maintaining secure authentication, isolated execution environments, and simple administration suitable for universities and small academic institutions.



\---



\## Project Objectives



The main objectives of MathBridge are:



\- provide seamless Single Sign-On (SSO) between ATutor and JupyterHub;

\- support interactive mathematical computations using SageMath and JupyterLab;

\- isolate user environments using Docker containers;

\- simplify deployment for universities with limited IT resources;

\- build a fully open-source educational ecosystem.



\---



\## Main Features



\- JWT-based Single Sign-On

\- Custom ATutor authentication module

\- Custom JupyterHub JWT Authenticator

\- DockerSpawner integration

\- SageMath notebooks

\- Container isolation

\- Lightweight deployment without Kubernetes

\- Designed for academic groups and university laboratories



\---



\## System Architecture



```

ATutor LMS

&#x20;     │

&#x20;     │ JWT

&#x20;     ▼

JupyterHub

&#x20;     │

DockerSpawner

&#x20;     │

Docker Container

&#x20;     │

&#x20;SageMath / JupyterLab

```



\---



\## Technology Stack



| Component | Technology |

|-----------|------------|

| Learning Management System | ATutor |

| Authentication | JSON Web Token (JWT) |

| Notebook Platform | JupyterHub (TLJH) |

| Containerization | Docker |

| Mathematical Software | SageMath |

| Programming Languages | PHP, Python |

| Operating System | Ubuntu Server |



\---



\## Repository Structure



```

analysis/        Experimental data analysis

atutor/          JWT module for ATutor

docker/          Docker configuration

docs/            Documentation

examples/        Example notebooks

jupyterhub/      JWT Authenticator

paper/           Scientific publications

screenshots/     Demonstration images

```



\---



\## Current Status



The project is under active development.



Completed:



\- JWT-based authentication

\- ATutor integration

\- JupyterHub integration

\- DockerSpawner configuration

\- SageMath environment

\- Experimental evaluation



Planned:



\- Cloud deployment

\- Learning analytics

\- Automated testing

\- LTI compatibility

\- Moodle integration



\---



\## Scientific Publications



The project serves as a research platform for studies in educational technologies, cloud computing, and mathematical software.



Publications will be listed here after publication.



\---



\## Documentation



Documentation is being prepared.



\---



\## License



The license will be specified after the first public release.



\---



\## Contact



\*\*Hryhorii Habrusiev\*\*



Ternopil Ivan Puluj National Technical University



Ukraine

