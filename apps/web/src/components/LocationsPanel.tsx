import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { Building2, Plus } from 'lucide-react'
import { useState } from 'react'
import type { FormEvent } from 'react'
import { ApiError, locationApi } from '@/api/client'
import { Feedback, Field, SubmitButton } from '@/components/FormFields'

export function LocationsPanel() {
  const [name, setName] = useState('')
  const queryClient = useQueryClient()
  const locations = useQuery({ queryKey: ['locations'], queryFn: locationApi.list })
  const create = useMutation({ mutationFn: locationApi.create, onSuccess: async () => { setName(''); await queryClient.invalidateQueries({ queryKey: ['locations'] }) } })
  function submit(event: FormEvent) { event.preventDefault(); create.mutate(name) }

  return <div className="mt-10 grid gap-6 lg:grid-cols-[1fr_0.8fr]">
    <section className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
      <div className="flex items-center gap-3"><Building2 className="size-6 text-orange-600" /><h2 className="text-xl font-semibold text-slate-950">Estabelecimentos</h2></div>
      {locations.isPending && <p className="mt-6 text-slate-500">Carregando estabelecimentos…</p>}
      {locations.error && <div className="mt-6"><Feedback>Não foi possível carregar os estabelecimentos.</Feedback></div>}
      {locations.data?.data.length === 0 && <div className="mt-6 rounded-2xl bg-slate-50 p-6 text-slate-600">Cadastre a primeira unidade para iniciar uma conexão com o iFood.</div>}
      <ul className="mt-6 divide-y divide-slate-100">{locations.data?.data.map((location) => <li className="flex items-center justify-between py-4" key={location.id}><span className="font-medium text-slate-900">{location.name}</span><span className="text-xs text-slate-400">#{location.id}</span></li>)}</ul>
    </section>
    <section className="h-fit rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
      <div className="flex items-center gap-3"><Plus className="size-5 text-orange-600" /><h2 className="font-semibold text-slate-950">Novo estabelecimento</h2></div>
      <form className="mt-6 space-y-5" onSubmit={submit}>
        {create.error && <Feedback>{create.error instanceof ApiError ? create.error.errors?.name?.[0] ?? create.error.message : 'Não foi possível cadastrar.'}</Feedback>}
        <Field label="Nome de identificação" maxLength={160} required value={name} onChange={(event) => setName(event.target.value)} />
        <SubmitButton pending={create.isPending}>Cadastrar estabelecimento</SubmitButton>
      </form>
    </section>
  </div>
}
