# Plataforma de Controle de Boletos

  O projeto trata-se de uma plataforma para pequenas e médias empresas que possibilita o cadastro de boletos a pagar e a receber e notifica o usuário da situação dos boletos. Quando um boleto a pagar está próximo de sua data de vencimento, uma notificação é exibida lembrando o usuário de pagar o boleto. Quando um boleto a receber já tiver passado de sua data de vencimento e não tiver sido pago, uma notificação é exibida lembrando o usuário de cobrar seu dividendo. A integração com o banco facilita o acesso a situação do boleto, sem a necessidade do usuário ter que checar com seu banco se o boleto já foi pago pelo cliente.


- Requisitos Funcionais
  - RF01: O sistema deve exibir os boletos com o seu estado (pago/pendente/atrasado)
  - RF02: O sistema deve mostrar notificações ao usuário dos boletos a serem pagos/recebidos
  - RF03: O sistema deve permitir upload de boletos
  - RF04: O sistema deve ser capaz de ler os dados dos boletos
  - RF05: O sistema deve exibir os boletos por ordem de prioridade de vencimento
  - RF06: O sistema deve mostrar o fluxo de caixa
  - RF07: O sistema permitir que o usuário altere o estado do boleto manualmente
  - RF08: O sistema deve atualizar automaticamente o estado do boleto quando integrado ao banco
  - RF09: O sistema deve permitir o cadastro de usuários
  - RF10: O sistema deve permitir autenticação de usuário

- Requisitos Não Funcionais
  - RNF01: O sistema deve ser integrado com uma API de banco para identificar a situação de cada boleto
  - RNF02: O sistema deve ser compatível com o navegador Google Chrome
