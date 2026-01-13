import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  plugins: [react()],
  base: './', // Use relative paths so it works on both alignedcal.com (root) and saconsumer.com/calendar/
  server: {
    host: true
  }
})
