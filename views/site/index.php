<?php

/*
hscstudio/yii2-fullcalendar: um fork/versão do FullCalendar para Yii2. Pode testar se o problema de posicionamento do botão é melhor lá.

marekpetras/yii2-calendarview-widget: um widget simples para calendário no estilo tabela, menos visual porém mais flexível para customizações.

Avaliar integrar diretamente o FullCalendar JavaScript oficial manualmente, sem wrapper Yii, para ter controle total.
*/
use yii\helpers\Url;
use yii\web\JsExpression;

/* $events vindo do controller */
$eventsJson = json_encode($events, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT);
$createUrl = Url::to(['reserva/create']);
$isGuest = Yii::$app->user->isGuest ? 'true' : 'false';
?>

<!-- FullCalendar v5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/pt-br.js"></script>

<div id="calendar"></div>

<!-- Modal Bootstrap -->
<div id="modal-reserva" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content"><!-- carregado via AJAX --></div>
  </div>
</div>

<style>
/* estilo discreto pro + */
.fc-add-btn {
  display:inline-block;
  width:20px;
  height:20px;
  line-height:18px;
  text-align:center;
  border-radius:50%;
  font-weight:bold;
  text-decoration:none;
  border:1px solid rgba(0,0,0,0.08);
  background: rgba(255,255,255,0.9);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var events = <?= $eventsJson ?>;
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    locale: 'pt-br',
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: events,
    // clique no dia (caso queira também clicar no dia inteiro)
    dateClick: function(info) {
      if (<?= $isGuest ?>) {
        alert('Faça login para criar uma reserva.');
        return;
      }
      // abre formulário em modal (GET)
      var date = info.dateStr || info.date.toISOString().slice(0,10);
      $.get('<?= $createUrl ?>', {data_do_evento: date}, function(data){
        $('#modal-reserva .modal-content').html(data);
        $('#modal-reserva').modal('show');
      }).fail(function(){ alert('Erro ao abrir formulário.'); });
    },

    // v5 hook para montar conteúdo de cada célula (coloca o botão +)
    dayCellDidMount: function(info) {
      if (<?= $isGuest ?>) return; // não mostra pra anônimo
      // cria o botão +
      var btn = document.createElement('a');
      btn.className = 'fc-add-btn';
      btn.href = '#';
      btn.innerText = '+';
      // data (YYYY-MM-DD)
      var dateIso = info.date.toISOString().slice(0,10);
      btn.setAttribute('data-date', dateIso);

      // posiciona e torna clicável
      btn.style.position = 'absolute';
      btn.style.top = '4px';
      btn.style.right = '6px';
      btn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var date = this.getAttribute('data-date');
        $.get('<?= $createUrl ?>', {data_do_evento: date}, function(data){
           $('#modal-reserva .modal-content').html(data);
           $('#modal-reserva').modal('show');
        }).fail(function(){ alert('Erro ao carregar formulário.'); });
      });

      // garante posição relativa do container e anexa
      info.el.style.position = 'relative';
      info.el.appendChild(btn);
    }
  });

  calendar.render();
});
</script>
