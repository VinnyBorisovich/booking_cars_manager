Техническое задание

В компании предусмотрена возможность выбора служебного автомобиля для служебной поездки на определенное время из не занятых другими сотрудниками. В служебной части корпоративного сайта необходимо будет размещать актуальную информацию о доступных для конкретного сотрудника автомобилях на запланированное время поездки.
Дополнительные условия:
- каждая модель автомобиля имеет определенную категорию комфорта (первая, вторая, третья... );
- для определенной должности сотрудников доступны только автомобили определенной категории комфорта (одной или нескольких категорий);
- за каждым автомобилем закреплён свой водитель.
Необходимо:
Написать компонент, который выводит для текущего сотрудника список свободных автомобилей на запрошенное время (запрошенное время начала и время окончания поездки передается от клиента на сервер в get-параметрах) с указанием модели, категории комфорта, водителя - шаблон c html-разметкой делать не нужно.



Для реализации задачи использовал следующий подход:
1.Пользователей, которым доступен сервис бронирования служебных автомобилей, необходимо добавить в группы пользователей,
соответствующие классу/типу авто. Для примера я создал 3 группы пользователей (Топ менеджмент, Управляющие, Рабочие).

2.Все данные об автомобилях, бронировании храняться в одном инфоблоке. Инфоблок состоит:
а) Корневые разделы, имеющие название класса авто (Base,Comfort,Premium). Необходимо использовать расширенное управление
   доступом к разделам и элементам, установив соответствующий доступ группам пользователей.
б) Внутри корневых разделов - подразделы, являющиеся "автомобилями" для бронирования. В описании раздела - данные
   водителя. Так же можно использовать пользовательские поля раздела для добавления различной информации (номер авто и
   т.д.).
в) Каждый "автомобиль"-подраздел внутри себя содержит элементы ИБ - элементы бронирования. Каждый содержит 2 свойства -
дата/время начала бронирования и конца бронирования.
