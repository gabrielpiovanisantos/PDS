# Plataforma de Controle de Boletos

O sistema possibilita o cadastro de boletos a pagar e a receber e notifica o usuário da situação dos boletos. Quando um boleto a pagar está próximo de sua data de vencimento, uma notificação é exibida lembrando o usuário de pagar o boleto. Quando um boleto a receber já tiver passado de sua data de vencimento, uma notificação é exibida lembrando o usuário de cobrar seu dividendo. A integração com o banco facilita o acesso a situação do boleto, sem a necessidade do usuário ter que checar com seu banco se o boleto já foi pago pelo cliente.


Requisitos Funcionais
- RF01: o sistema deve exibir a situação do boleto (pago/pendente/atrasado)
- RF02: o sistema deve mostrar notificações ao usuário dos boletos a serem pagos/recebidos
- RF03: o sistema deve permitir o upload de boletos
- RF04: o sistema deve ser capaz de ler os dados dos boletos

Requisitos Não Funcionais
- RNF01: o sistema deve ser integrado com uma api de banco para identificar a situação de cada boleto
