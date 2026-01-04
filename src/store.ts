import { create } from 'zustand';
import { persist } from 'zustand/middleware';

export type Mode = 'text' | 'color' | 'eyedropper';
interface DayData { text: string; color: string; }

interface CalendarStore {
  year: number;
  activeMode: Mode;
  customText: string;
  selectedColor: string;
  customizations: Record<string, DayData>;
  setYear: (y: number) => void;
  setMode: (m: Mode) => void;
  setCustomText: (t: string) => void;
  setSelectedColor: (c: string) => void;
  updateDay: (key: string, data: Partial<DayData>) => void;
  importData: (json: string) => void;
  clearAll: () => void;
}

export const useCalendarStore = create<CalendarStore>()(
  persist((set) => ({
    year: 2026,
    activeMode: 'text',
    customText: '',
    selectedColor: '#ffcccc',
    customizations: {},
    setYear: (year) => set({ year }),
    setMode: (activeMode) => set({ activeMode }),
    setCustomText: (customText) => set({ customText }),
    setSelectedColor: (selectedColor) => set({ selectedColor }),
    updateDay: (key, data) => set((s) => ({
      customizations: { ...s.customizations, [key]: { ...s.customizations[key], ...data } }
    })),
    importData: (json) => set({ customizations: JSON.parse(json) }),
    clearAll: () => { if(confirm("Clear all data?")) set({ customizations: {} }) },
  }), { name: 'linear-calendar-aligned-v1' })
);
