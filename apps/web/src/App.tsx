import { useQuery } from '@tanstack/react-query'
import { Activity, Cable, Database, Layers3 } from 'lucide-react'
import { getHealth } from '@/api/client'
import { StatusBadge } from '@/components/ui/status-badge'

const foundations = [
  { label: 'API', value: 'Laravel 13', icon: Cable },
  { label: 'Interface', value: 'React 19', icon: Layers3 },
  { label: 'Persistência', value: 'PostgreSQL', icon: Database },
]

export default function App() {
  const health = useQuery({ queryKey: ['health'], queryFn: getHealth })
  const status = health.isPending ? 'checking' : health.isSuccess ? 'online' : 'offline'
  const statusLabel = health.isPending
    ? 'Verificando API'
    : health.isSuccess
      ? 'API disponível'
      : 'API indisponível'

  return (
    <main className="min-h-screen px-6 py-12 sm:px-10">
      <section className="mx-auto max-w-5xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div className="border-b border-slate-200 bg-slate-950 px-8 py-10 text-white sm:px-12">
          <div className="mb-8 flex items-center justify-between gap-4">
            <span className="text-sm font-semibold tracking-[0.22em] text-emerald-300">COMENTARO</span>
            <StatusBadge status={status}>{statusLabel}</StatusBadge>
          </div>
          <h1 className="max-w-3xl text-4xl font-semibold tracking-tight sm:text-5xl">
            Fundação técnica pronta para evoluir por módulos.
          </h1>
          <p className="mt-5 max-w-2xl text-base leading-7 text-slate-300">
            Frontend e backend independentes, unidos por um contrato OpenAPI e preparados para o primeiro fluxo de acesso.
          </p>
        </div>
        <div className="grid gap-4 p-8 sm:grid-cols-3 sm:p-12">
          {foundations.map(({ label, value, icon: Icon }) => (
            <article className="rounded-2xl border border-slate-200 bg-slate-50 p-5" key={label}>
              <Icon className="mb-8 size-5 text-emerald-600" aria-hidden />
              <p className="text-sm text-slate-500">{label}</p>
              <p className="mt-1 font-semibold text-slate-900">{value}</p>
            </article>
          ))}
        </div>
        <div className="flex items-center gap-3 border-t border-slate-200 px-8 py-5 text-sm text-slate-600 sm:px-12">
          <Activity className="size-4" aria-hidden />
          <span>
            {health.data
              ? `${health.data.service} · versão ${health.data.version}`
              : 'Aguardando resposta do backend'}
          </span>
        </div>
      </section>
    </main>
  )
}
