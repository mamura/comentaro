import { useQuery } from '@tanstack/react-query'
import { MessageSquareText, Star } from 'lucide-react'
import { interactionApi } from '@/api/client'
import { Feedback } from '@/components/FormFields'

const priorities = { high: 'Alta', medium: 'Média', low: 'Baixa' } as const

export function InteractionsPanel() {
  const interactions = useQuery({ queryKey: ['interactions'], queryFn: interactionApi.list })

  return <section className="mt-6 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
    <div className="flex items-center gap-3"><MessageSquareText className="size-6 text-orange-600" /><h2 className="text-xl font-semibold text-slate-950">Interações recentes</h2></div>
    {interactions.isPending && <p className="mt-6 text-slate-500">Carregando interações…</p>}
    {interactions.error && <div className="mt-6"><Feedback>Não foi possível carregar as interações.</Feedback></div>}
    {interactions.data?.data.length === 0 && <p className="mt-6 rounded-2xl bg-slate-50 p-6 text-slate-600">As avaliações aparecerão aqui depois da primeira sincronização.</p>}
    <ul className="mt-6 divide-y divide-slate-100">{interactions.data?.data.map((interaction) => <li className="py-5" key={interaction.id}>
      <div className="flex flex-wrap items-center gap-3"><strong className="text-slate-950">{interaction.location.name}</strong><span className="flex items-center gap-1 text-sm text-amber-700"><Star className="size-4 fill-current" />{interaction.rating}</span><span className="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">Prioridade {priorities[interaction.priority]}</span></div>
      <p className="mt-2 text-slate-600">{interaction.comment || 'Avaliação sem comentário.'}</p>
      <p className="mt-2 text-xs text-slate-400">{new Date(interaction.occurred_at).toLocaleString('pt-BR')}</p>
    </li>)}</ul>
  </section>
}
