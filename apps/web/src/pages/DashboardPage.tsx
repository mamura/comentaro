import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import { LogOut, MailCheck } from 'lucide-react'
import { Navigate } from 'react-router-dom'
import { ApiError, authApi } from '@/api/client'
import { Feedback } from '@/components/FormFields'
import { LocationsPanel } from '@/components/LocationsPanel'

export function DashboardPage() {
  const queryClient = useQueryClient()
  const session = useQuery({ queryKey: ['auth-user'], queryFn: authApi.user, retry: false })
  const logout = useMutation({ mutationFn: authApi.logout, onSuccess: () => queryClient.setQueryData(['auth-user'], null) })
  const resend = useMutation({ mutationFn: authApi.resendVerification })

  if (session.isPending) return <main className="grid min-h-screen place-items-center text-slate-600">Carregando sua conta…</main>
  if (session.error instanceof ApiError && session.error.status === 401) return <Navigate replace to="/login" />
  if (!session.data) return <Navigate replace to="/login" />
  const user = session.data.user

  return <main className="min-h-screen bg-slate-50">
    <header className="border-b border-slate-200 bg-white"><div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4"><span className="font-semibold tracking-[0.16em] text-slate-950">COMENTARO</span><button className="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-950" onClick={() => logout.mutate()}><LogOut className="size-4" /> Sair</button></div></header>
    <section className="mx-auto max-w-6xl px-6 py-12">
      <p className="text-sm font-medium text-orange-700">{user.organization.name}</p><h1 className="mt-2 text-3xl font-semibold text-slate-950">Olá, {user.name}.</h1>
      {!user.email_verified ? <div className="mt-10 max-w-2xl rounded-3xl border border-amber-200 bg-amber-50 p-8"><MailCheck className="size-7 text-amber-700" /><h2 className="mt-5 text-xl font-semibold text-slate-950">Confirme seu endereço de e-mail</h2><p className="mt-2 leading-6 text-slate-600">Enviamos um link temporário para {user.email}. As funcionalidades internas serão liberadas depois da confirmação.</p>{resend.data && <div className="mt-4"><Feedback tone="success">{resend.data.message}</Feedback></div>}<button className="mt-6 rounded-xl bg-slate-950 px-5 py-3 font-semibold text-white disabled:opacity-60" disabled={resend.isPending} onClick={() => resend.mutate()}>Reenviar confirmação</button></div> : <LocationsPanel />}
    </section>
  </main>
}
