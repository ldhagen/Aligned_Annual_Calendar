  
# Calendar Planner

<p align="center">
  <img src="https://github.com/ldhagen/Aligned_Annual_Calendar/blob/main/assets/Screenshot.png?raw=true" alt="Calendar Screenshot" width="800">
</p>

---

# 📅 Aligned Linear Calendar

A high-performance, React-based web application designed for creating landscape-printable calendars with **perfect vertical weekday alignment**. Unlike traditional calendars, this linear format allows you to track project timelines, habits, or holidays in a continuous horizontal flow across months.

## ✨ Features

* **Vertical Weekday Alignment**: Every Monday (or Sunday, etc.) aligns in the exact same vertical track across all 12 months, creating a "staircase" visual effect that makes weekends easy to identify.
* **Persistent Customization**: Add text labels or custom colors to any day. Your data is automatically saved to browser LocalStorage.
* **Specialized Tooling**:
* **✎ Text Tool**: Quick-apply common labels (Holiday, Work, Deadline).
* **🎨 Color Tool**: Custom color picker for highlighting specific date ranges.
* **🧪 Eyedropper**: Sample existing colors from your calendar to reuse them elsewhere.


* **Data Portability**: Complete **💾 Export** and **📂 Import** functionality via JSON files to move your data between devices.
* **Print Optimized**: High-fidelity landscape printing with a specialized CSS media query that removes the UI and scales the calendar for A4/Letter paper.

---

## 🏗️ Architecture & Stack

* **Framework**: [React 18/19](https://react.dev/)
* **State Management**: [Zustand](https://github.com/pmndrs/zustand)
* **Build Tool**: [Vite 5](https://vitejs.dev/)
* **Styling**: Modern CSS Grid (Absolute column mapping logic)
* **Language**: TypeScript

---

## 🚀 Getting Started

### Prerequisites

* **Node.js**: Version 18.19.1 or higher.
* **npm**: Version 9 or higher.

### Local Development

1. **Clone the repository**:
```bash
git clone https://github.com/your-username/aligned-linear-calendar.git
cd aligned-linear-calendar

```


2. **Install dependencies**:
```bash
npm install

```


3. **Run the development server**:
```bash
npm run dev

```



---

## 🛠️ Troubleshooting Guide

| Issue | Cause | Solution |
| --- | --- | --- |
| **`EJSONPARSE` Error** | Syntax error in `package.json`. | Ensure no trailing commas in blocks. |
| **Node Version Mismatch** | Vite 6/7 requires Node 20+. | Use **Vite 5** if stuck on Node 18. |
| **`ERR_REQUIRE_ESM`** | Node treating files as CommonJS. | Add `"type": "module"` to `package.json`. |
| **Misaligned Weekends** | Relative CSS grid sizing. | Use `repeat(37, var(--cell-w))` in `App.css`. |
| **Docker No-Show** | Container port mapping. | Set `host: true` in `vite.config.ts`. |

---

## 🤝 How to Contribute

We welcome contributions from the **HagenCode Shop** team and the community. Please follow these steps:

1. **Fork the Project**: Create your own branch from `main`.
2. **Feature Branches**: Use descriptive names (e.g., `feat/add-quarterly-dividers` or `fix/ios-print-spacing`).
3. **Code Standards**:
* Ensure all new components are documented with TypeScript interfaces.
* Maintain the CSS variable system for colors and spacing.


4. **Testing**: Verify vertical alignment in 2025, 2026, and leap years (2028) before submitting.
5. **Submit a Pull Request**: Provide screenshots of any UI changes in the PR description.

---

## 👥 Contributors

* **HagenCode Shop**: Lead developer and architect.
* **Gemini**: AI thought partner; assistant in architectural refactoring, CSS grid logic, and debugging.

---

## 📜 License

Distributed under the **MIT License**. See `LICENSE` for more information.

---

