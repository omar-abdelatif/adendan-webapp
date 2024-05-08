@extends('frontend.layouts.master')
@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href={{route('site.index')}}>الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href={{route('site.assossiation')}}>لجان الجميعة</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">التفاصيل {{$association->name}}</li>
@endsection
@section('site')
    <section class="association_details mb-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title my-5 rounded-pill px-4 py-3 bg-primary text-white w-50 mx-auto">
                        <h1 class="text-center">عن {{$association->name}}</h1>
                        <p class="mb-0 mt-2 text-center fs-5">
                            المشرف:
                            <span class="ms-1">{{$association->boss}}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                @if ($association->name === 'اللجنة الرياضية')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/sports/undraw_goal_-0-v5v.svg')}}" width="450" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5">
                                تعد لجنة الرياضة في جمعية أدنــدان الخيرية عنصرًا أساسيًا في خططها لتطوير وتعزيز النشاط الرياضي في المجتمع المحلي. و يتضمن دور اللجنة في تنظيم مجموعة متنوعة من الأنشطة الرياضية، مثل البطولات وورش العمل، بهدف تعزيز الروح الرياضية وتشجيع المشاركة الواسعة
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تنمية الموارد')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5">
                                تعد لجنة تنمية الموارد جزءًا حيويًا من بنية الجمعية، حيث تركز على جمع وتطوير الموارد المالية والموارد الأخرى لضمان استدامة البرامج والمشاريع التي تقدمها الجمعية. يضمن دور اللجنة توفير الدعم اللازم لتحقيق الأهداف والرؤية الاستراتيجية للجمعية.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/resources/undraw_online_articles_re_yrkj.svg')}}" width="450" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تكريم الانسان')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5">
                                تعتبر لجنة تكريم الإنسان جزءًا أساسيًا من الهيكلية الإدارية للجمعية، حيث تتخذ على عاتقها إدارة وصيانة المقابر. و يكون لهذه اللجنة دور هام في الحفاظ على الأماكن المقدسة وتقديم خدمات للمجتمع المحلي
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/tombs/about_us.svg')}}" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'اللجنة الثقافية')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5">
                                اللجنة الثقافية هي جزء لا يتجزء من لجان جميعة أدندان الخيرية و التي لها دور كبير في المحافظة على التراث الثقافي النوبي. ويعكس دور اللجنة الثقافية في التزامها بالتنوع والتراث النوبي، و يمكن ان يشمل دور اللجنة في المزيد من الندوات الثقافية و الأنشطة الفنية التي تعكس الهوية والقيم النوبية.و يمكن ان يكون لديها مبادرات في تنظيم فعاليات ثقافية تعزز التبادل الثقافي وتقوي روح المجتمع.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/culture/Book_lover-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الرحلات')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5">
                                تعتبر لجنة الرحلات من اللجان الأساسية في جمعية أدندان الخيرية و هي لجنة ترفيهية تسعى الى تنظيم و تنسيق الحفلات و الرحلات الترفيهية و الثقافية و لأعضاء الجميعة و يكمن الدور الهام للجنة في تعزيز الترابط بين المجتمع النوبي و أكتساب المعرفة و الخبرات.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/journeys/About_us_page-bro.svg')}}" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الكفالة')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">نبذه عن اللجنة</h2>
                            <p class="fs-5 fw-bold">
                                تعد لجنة الكفالة جزءًا أساسيًا من هيكلية جمعية أدندان النوبية الخيرية، وتهتم بتنظيم وتنفيذ برامج الكفالة للفئات المحتاجة داخل المجتمع. يتم تكوين هذه اللجنة من أفراد متفانين يسعون لتوفير الدعم والرعاية للأفراد والعائلات ذوي الاحتياجات الخاصة.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/kfala/Humanitarian_Help-cuate.svg')}}" width="500" alt="about-img">
                        </div>
                    </div>
                @endif
            </div>
            <div class="row align-items-center justify-content-center">
                @if($association->name === 'اللجنة الرياضية')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4 mt-5">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                تتطلع لجنة الرياضة في جمعية أدنـــدان الخيرية إلى أن تكون رائدة في تعزيز ثقافة الرياضة وتفعيل دورها في بناء مجتمع صحي ومترابط من خلال توفير برامج وفعاليات رياضية متنوعة وملهمة.
                            </p>
                            <p class="fs-5 fw-bold">
                                و من أهداف اللجنة:
                                <ul>
                                    <li>تعزيز الروح الرياضية</li>
                                    <li>تنظيم أنشطة متنوعة</li>
                                    <li>تشجيع المواهب الرياضية</li>
                                    <li>تحسين البنية التحتية الرياضية</li>
                                    <li>التعاون مع الجهات الرياضية</li>
                                    <li>توعية الجماهير</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/sports/undraw_fitness_stats_sht6.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تنمية الموارد')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/resources/746e2565-a9be-42dd-84ae-1c76db0c5dd3.png')}}" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center my-5">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                "نعمل كل يوم على توفير الموارد الضرورية التي تمكّن جمعية أدندان من تحقيق رسالتها وتوفير الخدمات الرائدة للمجتمع النوبي، من خلال استدامة الدعم المالي وتعزيز التعاون مع الشركاء."
                            </p>
                            <p class="fs-5 fw-bold">
                                و من أهداف اللجنة:
                                <ul>
                                    <li>توفير الموارد المالية</li>
                                    <li>تنويع مصادر التمويل</li>
                                    <li>إقامة شراكات مؤثرة</li>
                                    <li>توسيع قاعدة الداعمين</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تكريم الانسان')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/tombs/Consulting-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                الرسالة التي تقدمها لجنة تكريم الإنسان هي تقديم خدمات إدارة المقابر بروح إنسانية ودينية، وتقديم الدعم لأسرهم في هذه اللحظات الصعبة.
                            </p>
                            <p class="fs-5 fw-bold">
                                و من أهداف اللجنة:
                                <ul>
                                    <li>تحسين بيئة المقابر</li>
                                    <li>توفير دعم للأسر</li>
                                    <li>توعية المجتمع</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'اللجنة الثقافية')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/culture/Reading_glasses-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                تهدف اللجنة الى حفظ وتعزيز التراث النوبي و التشجيع على التعبير الفني والتفاعل الثقافي لتعزيز فهم ووحدة المجتمع
                            </p>
                            <p class="fs-5 fw-bold">
                                أهداف اللجنة:
                                <ul>
                                    <li>حفظ التراث النوبي</li>
                                    <li>تشجيع الفنون التشكيلية والأدائية</li>
                                    <li>تنظيم معارض وفعاليات فنية</li>
                                    <li>توفير ورش العمل الفنية</li>
                                    <li>تعزيز التفاعل الثقافي</li>
                                    <li>دعم المشاريع الفنية الاجتماعية</li>
                                    <li>التعاون مع الجهات الفنية الوطنية والدولية</li>
                                    <li>تحقيق التواصل الفني بين الأجيال</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الرحلات')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/journeys/Email_campaign-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                "تسعى اللجنة إلى تعزيز التواصل والترابط الاجتماعي وتوفير فرص للترفيه والتعلم من خلال تنظيم رحلات وفعاليات متنوعة، بهدف إثراء حياة أفراد المجتمع النوبي وتعزيز الروح الجماعية."
                            </p>
                            <p class="fs-5 fw-bold">
                                و من أهداف اللجنة:
                                <ul>
                                    <li>تنظيم رحلات اجتماعية</li>
                                    <li>ترتيب فعاليات ترفيهية</li>
                                    <li>تنظيم رحلات تعليمية</li>
                                    <li>تشجيع المشاركة العائلية</li>
                                    <li>توعية بالمواقع السياحية</li>
                                    <li>تحفيز المشاركة الفعّالة</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الكفالة')
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/kfala/Humanitarian_Help-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرسالة و الأهداف</h2>
                            <p class="fs-5">
                                "نسعى كل لحظة إلى تقديم العون والدعم الشامل للفئات المحتاجة في مجتمعنا، من خلال برامج الكفالة، نهدف إلى تحسين ظروف حياتهم وتوفير بيئة داعمة للنمو والتطور."
                            </p>
                            <p class="fs-5 fw-bold">
                                <ul>
                                    <li>توفير دعم مالي مستدام</li>
                                    <li>تحسين الظروف المعيشية</li>
                                    <li>تقديم الدعم الاجتماعي</li>
                                    <li>توجيه الجهود للحالات الطارئة</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row align-items-center justify-content-center">
                @if($association->name === 'اللجنة الرياضية')
                    <div class="col-lg-6">
                        <div class="about-img text-center mt-3 overflow-hidden rounded-5">
                            <img src="{{asset('assets/frontend/images/associations/sports/undraw_target_re_fi8j.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                "تسعى لجنة الرياضة في جمعية أدندان الخيرية أن تكون الرائدة في تعزيز ثقافة النشاط البدني والرياضة، وأن تكون محركاً لتحفيز أفراد المجتمع لتحقيق أقصى إمكانياتهم البدنية والنفسية، وبناء مجتمع صحي ومتوازن."
                            </p>
                            <p class="fs-5 fw-bold">
                                و من مهام اللجنة:
                                <ul>
                                    <li>تنظيم الأنشطة الرياضية</li>
                                    <li>تشجيع المشاركة الواسعة</li>
                                    <li>توعية بفوائد الرياضة</li>
                                    <li>تطوير المواهب الرياضية</li>
                                    <li>التعاون مع الهيئات الرياضية المحلية</li>
                                    <li>تحسين البنية التحتية الرياضية</li>
                                    <li>تنظيم دورات تدريبية</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تنمية الموارد')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                "أن نكون محطة موثوقة لتأمين الموارد اللازمة لتحقيق رؤية وأهداف جمعية أدندان وأن نكون الرائدين في تطوير استراتيجيات جذب التمويل."
                            </p>
                            <p class="fs-5 fw-bold">
                                و من مهام اللجنة:
                                <ul>
                                    <li>تقييم الاحتياجات المالية</li>
                                    <li>تنظيم الحملات والفعاليات</li>
                                    <li>تطوير مستدام للتمويل</li>
                                    <li>التواصل مع الشركاء والداعمين</li>
                                    <li>تقديم تقارير دورية</li>
                                    <li>تقييم الفعالية</li>
                                    <li>المساهمة في استراتيجيات الجمعية</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/resources/88a3ce87-6899-4881-ad00-9f958eee15a3.png')}}" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة تكريم الانسان')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                اما رؤية لجنة تكريم الإنسان هي ان تكون رائدة في تقديم خدمات إدارة المقابر بمستوى عالٍ من الكفاءة والرعاية، محافظين على كرامة المتوفين وتوفير دعم قوي لأسرهم، مع الالتزام بالقيم الدينية والاحترام للتقاليد.
                            </p>
                            <p class="fs-5 fw-bold">
                                <ul>
                                    <li>تطوير مشاريع لتحسين المقابر</li>
                                    <li>تنظيم عمليات الدفن</li>
                                    <li>صيانة البنية التحتية</li>
                                    <li>الشفافية في الإدارة</li>
                                    <li>التعاون مع الجهات المعنية</li>
                                    <li>إدارة المقابر</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/tombs/Finding_brilliant_ideas_bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'اللجنة الثقافية')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                تسعى اللجنة الثقافية في جمعية أدندان الخيرية إلى أن تكون رائدة في تعزيز وحفظ التراث الثقافي النوبي، وتعزيز التعبير الفني كوسيلة لتعزيز التواصل والوحدة الاجتماعية في المجتمع النوبي.
                            </p>
                            <p class="fs-5 fw-bold">
                                و من مهام اللجنة:
                                <ul>
                                    <li>حفظ ونقل التراث النوبي</li>
                                    <li>تنظيم ندوات ثقافية و فنية</li>
                                    <li>دعم المواهب الفنية النوبية</li>
                                    <li>المشاركة في المهرجانات الثقافية</li>
                                    <li>التواصل مع الشباب</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/culture/Hand_holding_pen-cuate.svg')}}" width="380" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الرحلات')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                إن رؤية اللجنة هي ان تكون رائدة في تنظيم الرحلات بأنواعها و المسابقات التعليمية و تعزيز الترابط الأسري بين المجتمع النوبي و تقديم تجارب مميزه تثري حياه أفراد الجميعة.
                            </p>
                            <p class="fs-5 fw-bold">
                                و من مهام اللجنة:
                                <ul>
                                    <li>ضمان السلامة والراحة</li>
                                    <li>توفير فرص الترفيه والاستجمام</li>
                                    <li>تعزيز التواصل الاجتماعي</li>
                                    <li>توسيع أفق المعرفة</li>
                                    <li>تحقيق التنوع في الفعاليات</li>
                                    <li>تحفيز الاستكشاف والمغامرة</li>
                                    <li>توعية بالتراث والثقافة</li>
                                    <li>تعزيز روح المشاركة المجتمعية</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/journeys/journey-bro.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                @elseif ($association->name === 'لجنة الكفالة')
                    <div class="col-lg-6">
                        <div class="about-details" dir="rtl">
                            <h2 class="details-title text-center mb-4">الرؤية و المهام</h2>
                            <p class="fs-5">
                                "رؤيتنا ن نكون رائدين في تحقيق التميز، نسعى لبناء مجتمع يعتمد على التكافل والرعاية، حيث يحظى كل فرد فيه بالدعم الكامل لتحقيق إمكاناته والمشاركة الفعّالة في التنمية المستدامة."
                            </p>
                            <p class="fs-5 fw-bold">
                                من مهام اللجنة:
                                <ul>
                                    <li>تحديد الحالات المستحقة</li>
                                    <li>تقييم الاحتياجات</li>
                                    <li>توفير الدعم المالي</li>
                                    <li>تطوير برامج متكاملة</li>
                                    <li>التواصل مع المستفيدين</li>
                                    <li>البحث عن فرص تحسين الدخل</li>
                                    <li>رصد وتقييم الأثر</li>
                                    <li>تقديم خدمات الدعم الاجتماعي</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img text-center">
                            <img src="{{asset('assets/frontend/images/associations/kfala/Humanitarian_Help-rafiki.svg')}}" width="400" alt="about-img">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
