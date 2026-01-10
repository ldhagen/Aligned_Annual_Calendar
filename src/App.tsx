import { useRef } from 'react';
import { useCalendarStore } from './store';
import './App.css';

export default function App() {
  const s = useCalendarStore();
  const fileRef = useRef<HTMLInputElement>(null);
  const months = Array.from({ length: 12 }, (_, i) => i);

  const handleExport = () => {
    const dataStr = JSON.stringify(s.customizations, null, 2);
    const blob = new Blob([dataStr], { type: "application/json" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = `calendar-export-${s.year}.json`;
    link.click();
    URL.revokeObjectURL(url);
  };

  return (
    <div className="app-container" data-mode={s.activeMode}>
      <div className="toolbar no-print">
        <div className="group">
          <label>Year</label>
          <select value={s.year} onChange={e => s.setYear(Number(e.target.value))}>
            {[2025, 2026, 2027, 2028].map(y => <option key={y} value={y}>{y}</option>)}
          </select>
        </div>
        <div className="group">
          <label>Tool</label>
          <select value={s.activeMode} onChange={e => s.setMode(e.target.value as any)}>
            <option value="text">✎ Text</option>
            <option value="color">🎨 Color</option>
            <option value="eyedropper">🧪 Eyedropper</option>
          </select>
        </div>
        
        {s.activeMode === 'text' && (
          <div className="group">
            <label>Stamp Text</label>
            <input 
              type="text" 
              placeholder="Type label here..."
              value={s.customText} 
              onChange={e => s.setCustomText(e.target.value)}
              className="text-input"
            />
          </div>
        )}

        {s.activeMode === 'color' && (
          <div className="group">
            <label>Color</label>
            <input type="color" value={s.selectedColor} onChange={e => s.setSelectedColor(e.target.value)} />
          </div>
        )}
        
        <div className="spacer" />
        
        <button onClick={handleExport}>💾 Export</button>
        <button onClick={() => fileRef.current?.click()}>📂 Import</button>
        <button onClick={s.clearAll}>🗑️ Clear</button>
        <button className="print-btn" onClick={() => window.print()}>🖨️ Print PDF</button>
        
        <input 
          type="file" 
          ref={fileRef} 
          hidden 
          onChange={e => e.target.files?.[0]?.text().then(s.importData)} 
        />
      </div>

      <div className="printable-area">
        <h1 className="title">· {s.year} ·</h1>
        
        <WeekdayHeader />

        {months.map(m => <MonthRow key={m} month={m} year={s.year} />)}
        
        <CalendarLegend />
      </div>
    </div>
  );
}

function WeekdayHeader() {
  const weekdays = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
  return (
    <div className="month-row header-row">
      <div className="month-label"></div> 
      <div className="grid">
        {Array.from({ length: 37 }).map((_, i) => (
          <div 
            key={i} 
            className="header-cell"
            style={{ gridColumn: i + 1 }}
          >
            {weekdays[i % 7]}
          </div>
        ))}
      </div>
    </div>
  );
}

function CalendarLegend() {
  const { customizations } = useCalendarStore();
  
  const entries = Object.values(customizations).reduce((acc, curr) => {
    const id = `${curr.color}-${curr.text}`;
    if ((curr.text || curr.color) && !acc.find(e => `${e.color}-${e.text}` === id)) {
      acc.push(curr);
    }
    return acc;
  }, [] as { text: string; color: string }[]);

  if (entries.length === 0) return null;

  return (
    <div className="legend-container">
      <h3 className="legend-title">Legend</h3>
      <div className="legend-grid">
        {entries.map((entry, i) => (
          <div key={i} className="legend-item">
            <div className="legend-swatch" style={{ backgroundColor: entry.color || '#fff' }} />
            <span className="legend-text">{entry.text || '(No Label)'}</span>
          </div>
        ))}
      </div>
    </div>
  );
}

function MonthRow({ month, year }: { month: number, year: number }) {
  const name = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(year, month));
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const firstDayOffset = new Date(year, month, 1).getDay();

  return (
    <div className="month-row">
      <div className="month-label">{name}</div>
      <div className="grid">
        {Array.from({ length: daysInMonth }).map((_, i) => {
          const d = new Date(year, month, i + 1);
          const col = firstDayOffset + i + 1;
          return <DayCell key={i} date={d} col={col} />;
        })}
      </div>
    </div>
  );
}

function DayCell({ date, col }: { date: Date, col: number }) {
  const s = useCalendarStore();
  const key = date.toISOString().split('T')[0];
  const isWE = date.getDay() === 0 || date.getDay() === 6;
  const data = s.customizations[key] || { text: '', color: '' };
  
  const today = new Date();
  const isToday = date.getFullYear() === today.getFullYear() &&
                  date.getMonth() === today.getMonth() &&
                  date.getDate() === today.getDate();

  const onDBL = () => {
    if (s.activeMode === 'eyedropper') {
      s.setSelectedColor(data.color || (isWE ? '#d1d5db' : '#ffffff'));
      s.setMode('color');
    } else if (s.activeMode === 'text') {
      s.updateDay(key, { text: s.customText });
    } else {
      s.updateDay(key, { color: s.selectedColor });
    }
  };

  return (
    <div 
      className={`cell ${isWE ? 'we' : ''} ${isToday ? 'is-today' : ''}`} 
      style={{ gridColumn: col, backgroundColor: data.color }} 
      onDoubleClick={onDBL}
      title={data.text || undefined}
    >
      <span className="num">{date.getDate()}</span>
      <div className="txt">{data.text}</div>
      {isToday && <div className="today-indicator" />}
    </div>
  );
}
