import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { Building2, Link2, Plus } from 'lucide-react'
import { useState } from 'react'
import type { FormEvent } from 'react'
import { ApiError, connectionApi, locationApi } from '@/api/client'
import { Feedback, Field, SubmitButton } from '@/components/FormFields'

const statusLabels = {
  draft: 'Rascunho', access_requested: 'Acesso solicitado', awaiting_approval: 'Aguardando aprovação',
  activating: 'Ativando', active: 'Ativa', authorization_revoked: 'Autorização revogada',
  connection_failed: 'Falha na conexão', disconnected: 'Desconectada',
} as const

export function LocationsPanel() {
  const [name, setName] = useState('')
  const [selectedLocation, setSelectedLocation] = useState<number>()
  const [identifierType, setIdentifierType] = useState<'merchant_id' | 'cnpj'>('merchant_id')
  const [identifier, setIdentifier] = useState('')
  const queryClient = useQueryClient()
  const locations = useQuery({ queryKey: ['locations'], queryFn: locationApi.list })

  const activeLocation = selectedLocation ?? locations.data?.data[0]?.id

  const connections = useQuery({
    queryKey: ['connections', activeLocation],
    queryFn: () => connectionApi.list(activeLocation!),
    enabled: activeLocation !== undefined,
  })
  const create = useMutation({
    mutationFn: locationApi.create,
    onSuccess: async ({ data }) => {
      setName(''); setSelectedLocation(data.id)
      await queryClient.invalidateQueries({ queryKey: ['locations'] })
    },
  })
  const connect = useMutation({
    mutationFn: () => connectionApi.requestIFood(activeLocation!, { identifier_type: identifierType, identifier }),
    onSuccess: async () => {
      setIdentifier('')
      await queryClient.invalidateQueries({ queryKey: ['connections', activeLocation] })
    },
  })
  const integration = connections.data?.data.find((item) => item.provider === 'ifood')

  function submitLocation(event: FormEvent) { event.preventDefault(); create.mutate(name) }
  function submitConnection(event: FormEvent) { event.preventDefault(); connect.mutate() }

  return <div className="mt-10 space-y-6">
    <div className="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
      <section className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div className="flex items-center gap-3"><Building2 className="size-6 text-orange-600" /><h2 className="text-xl font-semibold text-slate-950">Estabelecimentos</h2></div>
        {locations.isPending && <p className="mt-6 text-slate-500">Carregando estabelecimentos…</p>}
        {locations.error && <div className="mt-6"><Feedback>Não foi possível carregar os estabelecimentos.</Feedback></div>}
        {locations.data?.data.length === 0 && <div className="mt-6 rounded-2xl bg-slate-50 p-6 text-slate-600">Cadastre a primeira unidade para iniciar uma conexão com o iFood.</div>}
        <ul className="mt-6 divide-y divide-slate-100">{locations.data?.data.map((location) => <li className="flex items-center justify-between py-4" key={location.id}><button className="font-medium text-slate-900 hover:text-orange-700" onClick={() => setSelectedLocation(location.id)} type="button">{location.name}</button><span className="text-xs text-slate-400">#{location.id}</span></li>)}</ul>
      </section>
      <section className="h-fit rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
        <div className="flex items-center gap-3"><Plus className="size-5 text-orange-600" /><h2 className="font-semibold text-slate-950">Novo estabelecimento</h2></div>
        <form className="mt-6 space-y-5" onSubmit={submitLocation}>
          {create.error && <Feedback>{create.error instanceof ApiError ? create.error.errors?.name?.[0] ?? create.error.message : 'Não foi possível cadastrar.'}</Feedback>}
          <Field label="Nome de identificação" maxLength={160} required value={name} onChange={(event) => setName(event.target.value)} />
          <SubmitButton pending={create.isPending}>Cadastrar estabelecimento</SubmitButton>
        </form>
      </section>
    </div>
    {activeLocation && <section className="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
      <div className="flex items-center gap-3"><Link2 className="size-5 text-orange-600" /><h2 className="text-xl font-semibold text-slate-950">Conexão com o iFood</h2></div>
      {connections.isPending && <p className="mt-6 text-slate-500">Carregando conexão…</p>}
      {connections.error && <div className="mt-6"><Feedback>Não foi possível carregar a conexão.</Feedback></div>}
      {integration ? <div className="mt-6 rounded-2xl bg-slate-50 p-6">
        <p className="font-medium text-slate-950">Estado: {statusLabels[integration.status]}</p>
        <p className="mt-2 text-sm text-slate-600">{integration.requested_identifier_type === 'cnpj' ? 'CNPJ' : 'ID iFood'}: {integration.requested_identifier}</p>
        <p className="mt-3 text-sm text-slate-500">A próxima etapa de autorização será habilitada quando as credenciais oficiais do iFood estiverem disponíveis.</p>
      </div> : !connections.isPending && <form className="mt-6 max-w-xl space-y-5" onSubmit={submitConnection}>
        {connect.error && <Feedback>{connect.error instanceof ApiError ? connect.error.errors?.identifier?.[0] ?? connect.error.message : 'Não foi possível registrar a conexão.'}</Feedback>}
        <label className="block text-sm font-medium text-slate-700">Identificador
          <select className="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3" value={identifierType} onChange={(event) => setIdentifierType(event.target.value as 'merchant_id' | 'cnpj')}>
            <option value="merchant_id">ID do estabelecimento no iFood</option><option value="cnpj">CNPJ</option>
          </select>
        </label>
        <Field label={identifierType === 'cnpj' ? 'CNPJ' : 'ID iFood'} maxLength={64} required value={identifier} onChange={(event) => setIdentifier(event.target.value)} />
        <SubmitButton pending={connect.isPending}>Salvar conexão em rascunho</SubmitButton>
      </form>}
    </section>}
  </div>
}
