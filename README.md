
<h1>Краткое описание</h1>
<p>По тз реализованы все методы, я также накатил nelmio_api_doc и добавил аннотации, чтобы можно было протыкать кейсы (это типа не соответствует принципу yagni, но я больше думал о своем удобстве, ну и как плюшка при проверке) 
<p>Я постарался выполнить все условия из тз, но есть пара моментов , которые я могу поправить, если будет немного больше времени.</p>
<ul>
  <li>Когда накатывал симфони, не учел про UUID и воспользовался mysql вместо postrge, когда обнаружил было уже поздно</li>
  <li>Не до конца разобрался с валидацией емайлов по уникальности, аннотации добавил по доке вроде, но не заработало, решил не зацикливаться.</li>
  <li>Не было ясности в тз, но я не учел отвязку родителя у детей, если родитель был удален, также под вопросом нужно ли удалять детей, если родитель был удален.</li>
  <li>Я не чистил композер от лишнего , только накатывал новые нужные пакеты, по сути небольшой мусор там ненужный</li>
  <li>Возможно еще какие то мелочи не заметил, нужно чуток больше времени чтобы выполнить функционал идеально.</li>
</ul>
