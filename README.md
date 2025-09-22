# Sistema Web para Reservas de Salas 

## Descrição

Este é o RASCUNHO DE UMA IDEIA DE aplicação web em PHP (usando framework Yii2) que oferece uma interface intuitiva para a reserva de salas. Gestores poderão cadastrar salas e suas regras, enquanto usuários normais (não gestores) logados poderão visualizar a disponibilidade em um calendário e realizar reservas. Usuários não logados terão a visão de um calendário apenas, e um link para login. O sistema validará automaticamente os agendamentos para prevenir conflitos e exibirá mensagens importantes sobre o uso das salas. 

## Usuários-Alvo

* **Gestor/Administrador:** Responsável por cadastrar e gerenciar as salas, definir suas regras e mensagens de aviso. 
* **Usuário Padrão:** Qualquer colaborador logado que precise reservar uma sala para uma reunião, treinamento ou outro evento.
* **Usuário Anônimo:** Qualquer usuário não logado que vai ver um calendário que mostra o que vai ter em cada dia(evento, horário de inicio e fim).
 

### Funcionalidades Essenciais 

* **Gestão de Salas:** CRUD completo para salas, com campos para nome, descrição e mensagem de aviso (pop-up), apenas para gestores.
* **Autenticação de Usuário:** Sistema de login para acesso à funcionalidade de reserva, que vai validar user/senha via LDAP
* **Mecanismo de Reserva:** Interface para usuário logado registrar reservas. No calendário, haverá pra cada dia exibido no calendário, além dos eventos já existentes no dia, um botão "+" com um link pra um formulário em que poderá ser informando título, público alvo, selecionando sala, hora de início (HH:MM) e hora do fim do evento (HH:MM). Ao submeter, deverá haver detecção de conflitos pra não sobrepor eventos na mesma sala, e se tiver ok, registrar a reserva e retornar para o calendário inicial, exibindo uma mensagem flash no topo se a reserva foi bem sucedida ou se deu erro/conflito.
* **Interface de Agendamento:**
* **Visão de Calendário Completo para usuário não logado:** Uma página com um calendário no estilo Google Calendar exibindo todos os eventos.
 

## Considerações Técnicas

* **Backend:** PHP, Framework Yii2.
* **Banco de Dados:** SQLite.
	
 
## Desenvolvimento
 
As tabelas a serem criadas no banco de dados: `reserva` , `sala` e `logins_usuarios`
	 
Base ficara em arquivo do SQLite na pasta .\data

Na raiz do app haverá um arquivo _configuracoes.php e nele será definido uma array de logins de gestores/administradores, como no exemplo abaixo.

$lista_gestores = ["admin" ];

O Login Form da aplicação que fará a autenticação via método autentica_usuario(). Pra ambiente inicial de testes, se o login for igual a senha, considera que o login está correto. Depois, confere se login está na tabela logins_usuarios,sendo que se não tiver, exibe mensagem informando acesso negado, e se tiver, habilita acesso ao formulário de cadastro de reserva. Se o login do usuário estiver na $lista_gestores assume que é login de gestor, e exibe tanto o formulário de cadastro de reserva quanto o formulário de cadastro de salas.


## O que já foi feito

1. Criar app básico no yii2 e instalar componentes adicionais via composer

2. Estruturar o banco de dados SQLite, na pasta .\app\data\

3. Implementar o sistema de autenticação de usuários (formulário de login do Yii2).

4. Executar "php yii serve" para subir e testar o app




## O que falta

A. Arrumar o formulário de cadastro (/index.php?r=reserva/create), pois quando submeto os dados da reserva (sala, título, hora de inicio e fim, etc.), ao clicar em Salvar, não está salvando.

B. Arrumar o calendário exibido na página inicial. O botão + de adicionar reserva está sobrepondo o número do dia..

C. Arrumar os controle de acesso da controladora das salas (SalaController), pois no momento todos acessam "/index.php?r=sala%2Findex", e o certo é só Gestor poderia gerenciar salas).

D. Arrumar os controle de acesso da controladora de reservas (ReservaController), pois no momento podem acessam "/index.php?r=sala%2Findex", e o certo só usuario logado pode reservar sala).

