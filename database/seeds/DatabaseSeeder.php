<?php

use App\Company;
use App\Contact;
use App\Digest;
use App\Subscription;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DigestsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(SubscriberListsTableSeeder::class);
        $this->call(ContactTableSeeder::class);
    }
}

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['name' => 'admin','username' => 'admin', 'password' => Hash::make('ilovedigest'), 'email' => 'alexlisp@tut.by']);
    }

}

class DigestsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('digests')->delete();

        Digest::create([
            'name' => 'Топливный ритейл. Новости 20.04.20.',
            'template' => 'retail-daily',
            'news' => '[{"img": "https://digest.vds.group/photos/xhTI5GZRYoICoCknCtgbLM8IyGNqxDo6aZsWqwTk.jpeg", "href": "https://www.business-gazeta.ru/article/465587", "excert": "«БИЗНЕС Online» продолжает новую рубрику, в которой предприниматели Татарстана рассказывают, как на них сказался нынешний кризис. Наш очередной герой — владелец группы компаний «Транзит Сити» Ринат Гаптельхаков — рассказал о снижении продаж топлива на 50–60%, росте популярности безопасной от COVID-19 бесконтактной формы оплаты и снижении цен на бензин. «Точки «критического пролива», когда уходим в минус, мы еще не достигли», — отмечает он.", "section": "analytics", "headline": "Владелец группы компаний «Транзит Сити» рассказал о снижении продаж топлива, росте популярности бесконтактной формы оплаты и снижении цен на бензин"}, {"img": null, "href": "https://www.belta.by/economics/view/toplivo-na-azs-v-belarusi-s-19-aprelja-desheveet-na-1-kopejku-387799-2020/", "excert": "В конце марта директор сети АЗС \"А-100\" Анна Красовская опубликовала на своей странице в Facebook довольно резонансный пост. Она высказалась об изменении курса белорусского рубля и начале эпидемии коронавируса, которые, по ее словам, обнажили все \"болячки\" и в обществе, и в бизнесе.", "section": "analytics", "headline": "После начала эпидемии важное стало еще важнее – директор сети АЗС \"А-100\" Красовская"}, {"img": null, "href": "https://www.rbc.ua/rus/styler/tseny-benzin-ukraine-eksperty-dali-neozhidannyy-1586935688.html", "excert": "Эксперты дали прогноз об изменениях цен на АЗС после заключения договора о понижении добычи нефти.", "section": "analytics", "headline": "Цены на бензин в Украине: эксперты дали неожиданный прогноз"}, {"img": null, "href": "http://iadevon.ru/news/petroleum/zavod_sovremennih_smazochnih_masel_sozdaetsya_na_taneko-10067/", "excert": "Нефтеперерабатывающий комплекс ТАНЕКО (Нижнекамск) сегодня производит 200 тысяч тонн базовых масел третьей группы в год. Сырьё для них - гидроочищенный остаток после производства бензина, керосина, дизеля. Есть планы получать продукты четвертой и пятой групп. Об этом генеральный директор комплекса «ТАНЕКО» Илшат САЛАХОВ сообщил в ходе интернет-конференции «БИЗНЕС Online».", "section": "development", "headline": "Завод современных смазочных масел создается на ТАНЕКО"}, {"img": "https://digest.vds.group/photos/8I5DTJ2cnm1EFEE8RdG0lTvoBZaxZK2z5cJyCNM5.jpeg", "href": "http://www.nefterynok.info/novosti/set-upg-otkryla-dva-novyh-azk", "excert": "В этом месяце сеть автозаправочных комплексов UPG, которая представленная на топливном рынке Украины в 16 областях, открыла два новых АЗК в городе Винница и поселке Чабаны Киевской области. Таким образом, к географии деятельности компании добавилась Винницкая область.Об этом сообщили в компании.", "section": "development", "headline": "Сеть UPG открыла два новых АЗК"}, {"img": "https://digest.vds.group/photos/z8pca1xHUXbzY3OZAgZSLVkAqFBj30gMKQw1u9rS.jpeg", "href": "https://www.neft.by/2020/04/17/belorusneft-rasshirjaet-set-terminalov-na-azs/", "excert": "«Белоруснефть» поэтапно внедряет систему самообслуживания в сети автозаправочных станций компании. Терминалы, позволяющие оплатить топливо и товары без помощи операторов, уже доступны в Гомельской и Гродненской областях. Когда осложнившаяся эпидемиологическая ситуация требует свести контакты к минимуму, это один из наиболее удобных вариантов быстрых покупок.", "section": "innovation", "headline": "«Белоруснефть» расширяет сеть терминалов на АЗС"}, {"img": "https://digest.vds.group/photos/9cC2Bfl1toyjNEm6XjehlySrQzxEaxYyicbAY0db.jpeg", "href": "https://vds.group/news/5698.html", "excert": "В марте 2020 г. в Алма-Ате прошло официальное открытие первой автозаправочной станций под новым брендом «Q». Фирменный стиль, дизайн и концепт воплощения автозаправочной станции «Q» разработаны креативной командой VDS. Конструкции и элементы брендового оформления экстерьера АЗС – произвели на Заводе Компании VDS.", "section": "reformat", "headline": "Первая АЗС под брендом «Q» получила архитектурно-дизайнерское решение от команды VDS"}, {"img": "https://digest.vds.group/photos/NWzuw9EOcedRKdkY2OWcr3HAt9XTlhOcMOJGeiOp.jpeg", "href": "https://m.minval.az/news/123981465", "excert": "Новая автозаправочная станция (АЗС) под брендом SOCAR была введена в эксплуатацию на участке Сумгайытского шоссе, около поста экологического контроля ГДП, проходящем через поселок Баладжары.", "section": "development", "headline": "SOCAR открыла еще одну заправку в Азербайджане"}, {"img": "https://digest.vds.group/photos/PDEZvsXToq1JQAEeHQK3Gzb1fWN7oAhRRCKynNcl.jpeg", "href": "https://www.facebook.com/superstation.pro/?ref=br_rs", "excert": "Производитель мороженого De IJswinckel и Berkman Energie Service объединили свои усилия для реализации Ice Drive Thru на территории автозаправочного комплекса в Барендрехте (Нидерланды).\n\nДвенадцать торговых точек De IJswinckel в настоящее время закрыты в рамках мер по борьбе с распространением коронавируса. Общую потерю оборота из-за закрытия предприятий общественного питания трудно оценить. Несмотря на сложившуюся ситуацию, сотрудничество компаний дает возможность поддерживать работу персонала и продолжать обслуживать клиентов. Начиная с 10 апреля можно купить вкусное свежеприготовленное мороженое прямо из автомобиля на АЗК Berkman.\n\nВ Ice Drive Thru клиенты могут выбирать из различных видов сорбетов, мороженого, молочных коктейлей, кофе со льдом, которые готовятся только из свежих и натуральных продуктов. Передвижной контейнер будет открыт ежедневно без выходных с 13 до 21 часа и доступен для автомобилей, мотоциклов, скутеров и велосипедов. В первом окне размещают и оплачивают заказ, а проехав к павильону получают его упакованным бесконтактно прямо в автомобиль.\n\nВ первое воскресенье работы приехало около 500 автомобилей. Среднее время ожидания заказа составило чуть более получаса. Кроме того, по акции за каждые заправленные 25 литров топлива на данной АЗС Berkman Tankstations, предоставляется купон на бесплатное мороженое.", "section": "retail", "headline": "Ice Drive Thru на автозаправочном комплексе в Нидерландах"}, {"img": "https://digest.vds.group/photos/vsaM5DuCiIoLJoQCM3O2Edc9gFUkdsbP087PtJMo.jpeg", "href": "https://lv.sputniknews.ru/world/20200418/13580473/Samyy-vostrebovannyy-produkt-na-samoizolyatsii-v-mire-rezko-podorozhalo-kofe.html", "excert": "По данным экспертов, из-за закрытия ресторанов, кафе и кофеен, а также перехода многих людей на удаленную работу, в магазинах наблюдается ажиотаж вокруг кофе.", "section": "retail", "headline": "В мире резко подорожал кофе"}, {"img": "https://digest.vds.group/photos/Vm0KklEHKLERc8D1DwvRkgVoa2bFvmWBlWTCGNvz.jpeg", "href": "https://neftegaz.ru/news/gas-stations/543407-rusgidro-v-2020-g-ustanovit-zaryadnye-stantsii-dlya-elektromobiley-na-sakhaline/", "excert": "Русгидро прорабатывает возможность размещения зарядных станций таким образом, чтобы обеспечить возможность поездок на электромобилях между ключевыми городами Дальнего Востока.", "section": "innovation", "headline": "Русгидро в 2020 г. установит зарядные станции для электромобилей на Сахалине"}, {"img": "https://digest.vds.group/photos/ivIKK6hTjLaYv0CpYb45YQZVNfjiHC9l7CuWI2Jt.jpeg", "href": "https://www.gazprom-neft.ru/press-center/news/gazprom_neft_predostavila_vozmozhnost_besplatnogo_servisnogo_obsluzhivaniya_avtomobilyam_skoroy_pomo/", "excert": "«Газпром нефть» начала бесплатное техобслуживание автомобилей скорой помощи на специализированных станциях G-Energy Service. В рамках программы «Антивирус» по противодействию распространению COVID-19 компания производит на станциях техобслуживания G-Energy Service замену моторного масла в автомобилях экстренных медицинских служб.", "section": "innovation", "headline": "«Газпром нефть» предоставила возможность бесплатного сервисного обслуживания автомобилям скорой помощи"}]',
            ]);

        Digest::create([
            'name' => 'Топливный ритейл. Новости 21.04.20',
            'template' => 'retail-daily',
            'news' => '[{"img": "https://digest.vds.group/photos/WK5LurQnbthfhizqJOvyP5iBHIaAW0M7d9dHijmS.jpeg", "href": "https://rg.ru/2020/04/20/pochemu-ceny-na-azs-ne-budut-padat-vsled-za-barrelem.html", "excert": "В России подешевело автомобильное топливо. Но в пределах 50 копеек в отдельных регионах, и только бензин. Дизель, наоборот, подорожал. Несмотря на затянувшееся снижение нефтяных цен, ждать серьезного падения стоимости автомобильного топлива не приходится.", "section": "analytics", "headline": "Почему цены на АЗС не будут падать вслед за баррелем"}, {"img": "https://digest.vds.group/photos/bLBkT114vYtnNuorGnZOLl18ngrzqfqjZXfvgJjc.jpeg", "href": "https://ria.ru/20200417/1570201592.html", "excert": "Комиссия по защите конкуренции Болгарии начала расследование в отношении нефтеперерабатывающего завода \"Лукойл Нефтохим Бургас\" по делу о недобросовестной конкуренции и завышении цен на бензин и дизельное топливо на фоне падения общемировых цен на сырую нефть, говорится в заявлении на сайте комиссии.", "section": "analytics", "headline": "В Болгарии заподозрили НПЗ \"Лукойла\" в завышении цен на бензин"}, {"img": "https://digest.vds.group/photos/DdGMbO7nz1WvpfZ6xuzDSqO8ayLCvmSvSQC2xUSv.jpeg", "href": "https://ru.delfi.lt/news/economy/set-zapravok-circle-k-vyhodit-na-rynok-prodazhi-produktov-po-internetu.d?id=84084835", "excert": "Сеть АЗС канадского капитала Circle K при сотрудничестве с платформой Bolt, начинает торговлю продуктами питания как из своего ассортимента, так и из своего кафе. Все необходимое можно заказать по интернету.\n\nЧитать далее: https://ru.delfi.lt/news/economy/set-zapravok-circle-k-vyhodit-na-rynok-prodazhi-produktov-po-internetu.d?id=84084835", "section": "retail", "headline": "Сеть заправок Circle K выходит на рынок продажи продуктов по интернету"}, {"img": "https://digest.vds.group/photos/3DuvIa6kiQsmG453p3Scr0jS0cZj8u7EAGxUSodU.jpeg", "href": "https://www.petrolplaza.com/news/24539", "excert": "Компания Royal Dutch Shell заявила о планах по расширению инвестиций в «зеленые» технологии для того, чтобы к 2050 году полностью прекратить производство углеродных выбросов в атмосферу. При этом, представители компании отмечают, что существует вероятность того, что эта цель будет достигнута раньше 2050 года.\nShell также заявила, что поднимет планку и сделает все возможное, чтобы к 2030 году  сократить вредные выбросы не на 20%, а на 30%.\nУскорение процесса трансформации Shell в «зеленую» компанию соответствует цели общества по ограничению допустимого повышения средней температуры до 1,5 градуса Цельсия. Данная цель была поставлена на Парижской конференции по климату в 2015 году.\n«Пандемия COVID-19 оказывает серьезное воздействие на здоровье людей и нашу экономику, поэтому уже можно говорить о тяжелых временах. Тем не менее, даже в этот момент борьбы с вызовом, с которым здесь и сейчас столкнулось все человечество, мы не можем забывать о будущем и должны всегда планировать на долгосрочную перспективу», - сказал Бен ван Берден, исполнительный директор Royal Dutch Shell.\n«Отношение общества к климатическим проблемам быстро меняется, и поэтому Shell должна повышать себе планку в этой сфере, и именно поэтому мы стремимся стать экологически-чистым энергетическим бизнесом с нулевыми выбросами к 2050 году или раньше. Менее амбициозная цель не соответствовала бы общественным ожиданиям», - добавил ван Берден.\nБолее детально дальнейшая программа действий будет изложена на ежегодном брифинге Shell по ответственным инвестициям, который состоится в четверг.\nПервым крупным игроком, поставившим перед собой цель стать компанией с нулевыми выбросами к 2050 году, стала испанская нефтяная компания Repsol.\n(Перевод Компании VDS)", "section": "development", "headline": "Shell  заявила о полном отказе от углеродных выбросов в атмосферу к 2050 году"}, {"img": null, "href": "https://enkorr.ua/ru/news/klo_otkroet_kapsulnuyu_gostinicu_na_azk_v_kieve/241141", "excert": "Сеть АЗК KLO планирует открыть капсульную гостиницу на модернизированном АЗК в Киеве по проспекту Бажана. Об этом в эфире проекта «НаКарантине» на YouTube-канале enkorr сообщил совладелец сети Вячеслав Стешенко.", "section": "development", "headline": "KLO откроет капсульную гостиницу на АЗК в Киеве"}, {"img": "https://digest.vds.group/photos/sC0ENXhJ7TnRpyoZ3OshUqfrqrkcOjFSlDk6uFn5.jpeg", "href": "https://news.ngs.ru/more/69092923/", "excert": "Чтобы остановить распространение вируса и обезопасить себя и близких, сейчас очень важно соблюдать рекомендации врачей: не контактировать с другими людьми, избегать очередей и по возможности отказаться от использования наличных денег. Для водителей выходом из ситуации стала бесконтактная оплата топлива через Яндекс.Навигатор — заправить автомобиль теперь можно, не выходя из машины.", "section": "innovation", "headline": "Яндекс.Навигатор помогает водителям беречь себя за рулём"}]',
        ]);
    }

}

class SubscriberListsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('subscriptions')->delete();

        Subscription::create(['name' => 'Тестовый список', 'short' => 'Тест']);
        Subscription::create(['name' => 'Топливный ритейл. Новости (ежедневно)', 'short' => 'ТР Еж']);
        Subscription::create(['name' => 'Новости топливного ритейла. Итоги недели', 'short' => 'ТР нед']);
        Subscription::create(['name' => 'Развитие городской среды. Архитектура и айдентика', 'short' => 'РГС']);
    }

}
class CompanyTableSeeder extends Seeder {

    public function run()
    {
        DB::table('companies')->delete();

        Company::create(['name' => 'Без компании']);
    }

}

class ContactTableSeeder extends Seeder {

    public function run()
    {
        DB::table('contacts')->delete();

        $companyId = Company::where('name','Без компании')->first()->id;
        $subscription = Subscription::findOrFail(1);

        Contact::create(['name' => 'Александров', 'email' => 'aliaksei.aliaksandrau@gmail.com', 'company_id' => $companyId, 'position' => 'Разработчик'])->subscriptions()->sync($subscription, false);
        Contact::create(['name' => 'Александров 2', 'email' => 'aliaksandrau@live.com', 'company_id' => $companyId]);
        Contact::create(['name' => 'Алексей Васильев', 'email' => 'a.vasiliev@vds.by', 'company_id' => $companyId]);
        Contact::create(['name' => 'Александр Гладкий', 'email' => 'a.gladkiy@vds.by', 'company_id' => $companyId]);

        $contacts = Contact::all();

        foreach ($contacts as $contact) {
            $contact->subscriptions()->sync($subscription, false);
        }

/*        Contact::create(['name' => 'Ivanov', 'email' => 'ivanov@vds.by', 'company_id' => $companyId]);
        Contact::create(['name' => 'petrov', 'email' => 'petrov@vds.by', 'company_id' => $companyId]);
        Contact::create(['name' => 'sidorov', 'email' => 'sidorov@vds.by']);
        Contact::create(['name' => 'vas', 'email' => 'vas@vds.by', 'company_id' => $companyId]);
        Contact::create(['name' => 'wqewqewqeqwe', 'email' => 'qweqweqweqwe@vds.by', 'company_id' => $companyId]);*/

    }

}
