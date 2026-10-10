import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import { render, screen } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'
import { afterEach, expect, it, vi } from 'vitest'
import App from './App'

afterEach(() => vi.restoreAllMocks())

it('shows the login journey', () => {
  render(<QueryClientProvider client={new QueryClient()}><MemoryRouter initialEntries={['/login']}><App /></MemoryRouter></QueryClientProvider>)
  expect(screen.getByRole('heading', { name: 'Entre na sua conta' })).toBeInTheDocument()
  expect(screen.getByRole('button', { name: 'Entrar' })).toBeInTheDocument()
})

it('blocks the internal journey until the email is verified', async () => {
  vi.spyOn(globalThis, 'fetch').mockResolvedValue(new Response(JSON.stringify({ user: { id: 1, name: 'Ana', email: 'ana@example.com', email_verified: false, organization: { id: 1, name: 'Organização A' } } }), { status: 200, headers: { 'Content-Type': 'application/json' } }))
  render(<QueryClientProvider client={new QueryClient()}><MemoryRouter initialEntries={['/']}><App /></MemoryRouter></QueryClientProvider>)
  expect(await screen.findByRole('heading', { name: 'Confirme seu endereço de e-mail' })).toBeInTheDocument()
})


it('shows locations and the interaction inbox for the authenticated organization', async () => {
  vi.spyOn(globalThis, 'fetch').mockImplementation(async (input) => {
    const url = String(input)
    const json = url.endsWith('/auth/user')
      ? { user: { id: 1, name: 'Ana', email: 'ana@example.com', email_verified: true, organization: { id: 1, name: 'Organização A' } } }
      : url.endsWith('/locations')
        ? { data: [{ id: 10, name: 'Unidade Centro' }] }
        : { data: [] }

    return new Response(JSON.stringify(json), { status: 200, headers: { 'Content-Type': 'application/json' } })
  })
  render(<QueryClientProvider client={new QueryClient()}><MemoryRouter initialEntries={['/']}><App /></MemoryRouter></QueryClientProvider>)
  expect(await screen.findByText('Unidade Centro')).toBeInTheDocument()
  expect(screen.getByRole('heading', { name: 'Interações recentes' })).toBeInTheDocument()
  expect(screen.getByRole('button', { name: 'Cadastrar estabelecimento' })).toBeInTheDocument()
  expect(await screen.findByRole('heading', { name: 'Conexão com o iFood' })).toBeInTheDocument()
  expect(screen.getByRole('button', { name: 'Salvar conexão em rascunho' })).toBeInTheDocument()
})
