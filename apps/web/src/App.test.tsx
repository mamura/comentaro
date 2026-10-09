import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import { render, screen } from '@testing-library/react'
import { afterEach, vi } from 'vitest'
import App from './App'

afterEach(() => {
  vi.restoreAllMocks()
})

it('shows the foundation and confirms the API status', async () => {
  vi.spyOn(globalThis, 'fetch').mockResolvedValue(
    new Response(JSON.stringify({
      status: 'ok',
      service: 'comentaro-api',
      version: '0.1.0',
      timestamp: '2026-10-09T12:00:00Z',
    }), {
      status: 200,
      headers: { 'Content-Type': 'application/json' },
    }),
  )

  const queryClient = new QueryClient({
    defaultOptions: { queries: { retry: false } },
  })

  render(
    <QueryClientProvider client={queryClient}>
      <App />
    </QueryClientProvider>,
  )

  expect(screen.getByRole('heading', {
    name: /fundação técnica pronta para evoluir por módulos/i,
  })).toBeInTheDocument()
  expect(await screen.findByText('API disponível')).toBeInTheDocument()
})
