

<p align="center">
  <img src="https://github.com/ldhagen/Aligned_Annual_Calendar/blob/main/assets/Screenshot.png?raw=true" alt="Calendar Screenshot" width="800">
</p>

---

# 📅 Aligned Linear Calendar

A high-performance, React-based web application designed for creating landscape-printable calendars with **perfect vertical weekday alignment**. Unlike traditional calendars, this linear format allows you to track project timelines, habits, or holidays in a continuous horizontal flow across months.

## ✨ Features

* **Vertical Weekday Alignment**: Every Monday aligns in the exact same vertical track across all 12 months, creating a "staircase" effect that makes identifying weekends and patterns effortless.
* **Free-Text Stamp Tool**: Type any label (e.g., "Holiday", "Deadline", "Vacation") in the toolbar and double-click any day cell to "stamp" that text instantly.
* **Dynamic Print Legend**: The application automatically generates a color-coded legend at the bottom of the page based on the labels and colors you use, ensuring your printed calendar is fully readable without digital tooltips.
* **Hover Tooltips**: In the digital view, hover over any cell to see the full text content, which is useful for longer notes that may be truncated in the grid.
* **Persistent Customization**: Your data is automatically saved to browser `LocalStorage`, so your progress is never lost between sessions.
* **Data Portability**: Complete **💾 Export** and **📂 Import** functionality via JSON files allows you to back up your data or move it between devices.
* **Print Optimized**: High-fidelity landscape printing with a specialized CSS media query that removes the UI and scales the calendar perfectly for A4/Letter paper.

---

## 🐳 Docker Deployment

The project includes a GitHub Action to automatically build and push the image to Docker Hub.

### 1. Simple Docker Run

```bash
docker run -d \
  --name linear-calendar \
  -p 3000:80 \
  --restart always \
  ldhagen/linear-calendar:latest

```

### 2. Docker-Compose Setup

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

---

## 🚀 Local Development

### Prerequisites

* **Node.js**: Version 18.19.1 or higher.
* **npm**: Version 9 or higher.

### Setup

1. **Clone the repository**:
```bash
git clone https://github.com/your-username/aligned-linear-calendar.git
cd aligned-linear-calendar

```


2. **Install dependencies**:
```bash
npm install

```


3. **Run development server**:
```bash
npm run dev

```



---

## 🛠️ Troubleshooting Guide

| Issue | Cause | Solution |
| --- | --- | --- |
| **Missing Color in PDF** | Background graphics disabled. | Enable **Background Graphics** in your browser's print dialog settings. |
| **`EJSONPARSE` Error** | Syntax error in `package.json`. | Ensure no trailing commas in blocks. |
| **Node Version Mismatch** | Vite 6/7 requires Node 20+. | Use **Vite 5** if stuck on Node 18. |
| **Misaligned Weekends** | Relative CSS grid sizing. | Use `repeat(37, var(--cell-w))` in `App.css`. |

---

## 🤝 How to Contribute

We welcome contributions from the **HagenCode Shop** team.

1. **Fork the Project**: Create your own branch from `main`.
2. **Testing**: Verify vertical alignment in 2025, 2026, and leap years (e.g., 2028) before submitting.
3. **Standards**: Maintain the CSS variable system for colors and spacing to ensure grid integrity.

---

## 👥 Contributors

* **HagenCode Shop**: Lead developer and architect.
* **Gemini**: AI thought partner; assistant in architectural refactoring, grid logic, and feature implementation.

---

## 📜 License

Distributed under the **MIT License**.

---
