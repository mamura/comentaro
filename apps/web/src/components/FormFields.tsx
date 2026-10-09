import type { InputHTMLAttributes, ReactNode } from 'react'

export function Field({ label, error, ...props }: InputHTMLAttributes<HTMLInputElement> & { label: string; error?: string }) {
  return <label className="block text-sm font-medium text-slate-700">{label}<input className="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-950 outline-none transition focus:border-orange-500 focus:ring-3 focus:ring-orange-100" {...props} />{error && <span className="mt-1 block text-sm text-red-600">{error}</span>}</label>
}

export function SubmitButton({ children, pending }: { children: ReactNode; pending: boolean }) {
  return <button className="w-full rounded-xl bg-slate-950 px-4 py-3 font-semibold text-white transition hover:bg-slate-800 disabled:cursor-wait disabled:opacity-60" disabled={pending} type="submit">{pending ? 'Aguarde…' : children}</button>
}

export function Feedback({ children, tone = 'error' }: { children: ReactNode; tone?: 'error' | 'success' }) {
  return <div role="status" className={`rounded-xl border px-4 py-3 text-sm ${tone === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : 'border-red-200 bg-red-50 text-red-700'}`}>{children}</div>
}
