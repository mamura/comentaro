import { MessageSquareText } from 'lucide-react'
import type { ReactNode } from 'react'

export function AuthLayout({ title, description, children }: { title: string; description: string; children: ReactNode }) {
  return (
    <main className="grid min-h-screen bg-slate-50 lg:grid-cols-[1.05fr_0.95fr]">
      <section className="hidden bg-slate-950 p-12 text-white lg:flex lg:flex-col lg:justify-between">
        <div className="flex items-center gap-3 text-sm font-semibold tracking-[0.2em] text-orange-300">
          <MessageSquareText className="size-6" /> COMENTARO
        </div>
        <div className="max-w-xl">
          <p className="text-4xl font-semibold leading-tight">Suas avaliações em um fluxo claro de atenção e resposta.</p>
          <p className="mt-5 leading-7 text-slate-300">Começamos pelo iFood para reunir contexto, prioridade e acompanhamento em um só lugar.</p>
        </div>
        <p className="text-sm text-slate-500">Central de reputação multicanal</p>
      </section>
      <section className="flex items-center justify-center px-6 py-12">
        <div className="w-full max-w-md">
          <div className="mb-10 flex items-center gap-2 font-semibold text-slate-950 lg:hidden"><MessageSquareText className="size-5 text-orange-600" /> Comentaro</div>
          <h1 className="text-3xl font-semibold tracking-tight text-slate-950">{title}</h1>
          <p className="mt-3 leading-6 text-slate-600">{description}</p>
          <div className="mt-8">{children}</div>
        </div>
      </section>
    </main>
  )
}
