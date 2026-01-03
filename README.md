

<p align="center">
  <img src="https://github.com/ldhagen/Aligned_Annual_Calendar/blob/main/assets/Screenshot.png?raw=true" alt="Calendar Screenshot" width="800">
</p>

---

# 📅 Aligned Linear Calendar

A high-performance, React-based web application designed for creating landscape-printable calendars with **perfect vertical weekday alignment**.


## ✨ Features

* **Vertical Weekday Alignment**: Perfect vertical tracks for weekends across all 12 months.
* **Persistent Customization**: Auto-save to LocalStorage.
* **Specialized Tooling**: Text labels, custom color picker, and an eyedropper tool.
* **Data Portability**: **💾 Export** and **📂 Import** via JSON files.
* **Print Optimized**: High-fidelity landscape printing via CSS media queries.

---

## 🚀 Getting Started

### Prerequisites

* **Node.js**: Version 18.19.1 or higher.
* **Docker**: Installed and running (if deploying via container).

### Local Development

1. **Clone & Install**:

```bash
git clone https://github.com/your-username/aligned-linear-calendar.git
cd aligned-linear-calendar
npm install

```

2. **Run**: `npm run dev`

---

## 🐳 Docker Deployment

The application is containerized using `nginx:stable-alpine` and is pushed to Docker Hub via GitHub Actions.

### 1. Simple Docker Launch

Use this one-liner to pull and run the latest version on port **3000**:

```bash
docker run -d \
  --name linear-calendar \
  -p 3000:80 \
  --restart always \
  ldhagen/linear-calendar:latest

```

### 2. Docker-Compose (Recommended)

Create a `docker-compose.yml` for a more permanent setup or for use in Portainer:

```yaml
version: '3.8'
services:
  calendar:
    image: ldhagen/linear-calendar:latest
    container_name: linear-calendar
    ports:
      - "3000:80"
    restart: always

```

**Launch**: `docker-compose up -d`

---

## 🛠️ Troubleshooting Guide

| Issue | Cause | Solution |
| --- | --- | --- |
| **`EJSONPARSE` Error** | Syntax error in `package.json`. | Ensure no trailing commas. |
| **Node Version** | Vite requires modern Node. | Use Node 18+ or Vite 5. |
| **Misaligned Weekends** | Relative CSS grid sizing. | Use `repeat(37, var(--cell-w))` in `App.css`. |
| **Docker No-Show** | Port mapping issue. | Map host port to container port **80**. |

---

## 🤝 How to Contribute

1. **Fork** and create a feature branch.
2. **Standardize**: Use TypeScript interfaces and the existing CSS variable system.
3. **Verify**: Check alignment for leap years (e.g., 2028) before submitting.

---

## 👥 Contributors

* **HagenCode Shop**: Lead developer and architect.
* **Gemini**: AI thought partner; assistant in refactoring and grid logic.

---

## 📜 License

Distributed under the **MIT License**.
