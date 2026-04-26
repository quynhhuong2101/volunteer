<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chứng nhận - {{ $user->name }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&family=Roboto:wght@300;400;500&display=swap&subset=vietnamese" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { 
                size: A4 landscape; 
                margin: 0;
            }
            body { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                margin: 0;
                padding: 0;
                width: 297mm;
                height: 210mm;
                overflow: hidden;
            }
            .no-print { 
                display: none !important; 
            }
            .certificate-container {
                width: 297mm !important;
                height: 210mm !important;
                max-width: 297mm !important;
                max-height: 210mm !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 8px double #B88746 !important; /* Adjust border for print */
                box-shadow: none !important;
                page-break-after: avoid;
                page-break-inside: avoid;
            }
        }
        
        .font-script { font-family: 'Dancing Script', cursive; }
        .font-serif { font-family: 'Merriweather', 'Times New Roman', serif; }
        
        .certificate-border {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4 print:p-0 print:bg-white print:block">

    <!-- Actions -->
    <div class="no-print fixed top-4 right-4 flex gap-2 z-50">
        <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-blue-700 transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            In Chứng Nhận
        </button>
        <a href="{{ route('student.activities.history') }}" class="flex items-center gap-2 bg-white text-gray-700 font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-gray-50 transition-all border border-gray-200">
            Quay lại
        </a>
    </div>

    <!-- Certificate Container (A4 Landscape: 297mm x 210mm) -->
    <!-- Certificate Container (A4 Landscape: 297mm x 210mm) -->
    <div class="certificate-container relative w-[297mm] h-[210mm] bg-[#FFFCF5] shadow-2xl mx-auto flex flex-col justify-between overflow-hidden box-border p-8" style="font-family: 'Times New Roman', serif;">
        
        <!-- Classic Academic Border -->
        <div class="absolute inset-0 pointer-events-none z-0">
             <svg width="100%" height="100%" viewBox="0 0 1122 794" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r="0.5" fill="#B88746" opacity="0.2"/>
                    </pattern>
                </defs>
                
                <!-- Background Texture -->
                <rect width="100%" height="100%" fill="url(#grid)" />

                <g fill="none" stroke="#B88746">
                    <!-- Main Double Border -->
                    <rect x="20" y="20" width="1082" height="754" stroke-width="3"/>
                    <rect x="30" y="30" width="1062" height="734" stroke-width="1"/>
                    
                    <!-- Inner Box -->
                    <rect x="45" y="45" width="1032" height="704" stroke-width="0.5" opacity="0.6"/>

                    <!-- Corner Flourishes (Styled as classic brackets) -->
                    <!-- Top Left -->
                    <path d="M20 120 V20 H120" stroke-width="5"/>
                    <path d="M50 100 V50 H100" stroke-width="2"/>
                    <circle cx="20" cy="20" r="6" fill="#B88746" stroke="none"/>

                    <!-- Top Right -->
                    <path d="M1102 120 V20 H1002" stroke-width="5"/>
                    <path d="M1072 100 V50 H1022" stroke-width="2"/>
                    <circle cx="1102" cy="20" r="6" fill="#B88746" stroke="none"/>

                    <!-- Bottom Left -->
                    <path d="M20 674 V774 H120" stroke-width="5"/>
                    <path d="M50 694 V744 H100" stroke-width="2"/>
                    <circle cx="20" cy="774" r="6" fill="#B88746" stroke="none"/>

                    <!-- Bottom Right -->
                    <path d="M1102 674 V774 H1002" stroke-width="5"/>
                    <path d="M1072 694 V744 H1022" stroke-width="2"/>
                    <circle cx="1102" cy="774" r="6" fill="#B88746" stroke="none"/>
                </g>
                
                </g>
            </svg>
        </div>

        <!-- Watermark -->
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.15] pointer-events-none z-0">
             <img src="{{ asset('images/logo-hv.png') }}" class="w-[500px] h-[500px] object-contain pt-10">
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col h-full text-center items-center justify-between py-6 px-16">
            
            <!-- Header -->
            <div class="mt-4">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-500 mb-2">Đoàn Thanh Niên - Hội Sinh Viên</h3>
                <h2 class="text-2xl font-black uppercase tracking-wider text-[#B88746] mb-1">HỌC VIỆN PHỤ NỮ VIỆT NAM</h2>
                <div class="w-1/3 h-px bg-gradient-to-r from-transparent via-[#B88746]/50 to-transparent mx-auto"></div>
            </div>

            <!-- Title -->
            <div class="mt-2">
                <h1 class="text-[3.5rem] font-bold text-[#1e3a8a] uppercase tracking-normal leading-tight font-serif" 
                    style="font-family: 'Merriweather', serif; text-shadow: 1px 1px 0px rgba(0,0,0,0.05);">
                    GIẤY CHỨNG NHẬN
                </h1>
            </div>

            <!-- Recipient -->
            <div class="w-full">
                <p class="text-lg text-gray-600 italic mb-2">Trân trọng ghi nhận và tuyên dương sinh viên:</p>
                <div class="text-[3.5rem] font-script text-[#B88746] leading-snug px-8 inline-block relative">
                    {{ $user->name }}
                    <!-- Underline decoration -->
                    <div class="absolute bottom-2 left-10 right-10 h-0.5 bg-[#B88746]/30 rounded-full"></div>
                </div>
            </div>

            <!-- Event -->
            <div class="w-full max-w-4xl mx-auto">
                <p class="text-lg text-gray-600 italic mb-1">Đã tham gia tích cực và hoàn thành xuất sắc sự kiện:</p>
                <h3 class="text-2xl font-bold text-gray-800 uppercase leading-relaxed px-4 py-2">
                    {{ $event->title }}
                </h3>
            </div>

            <!-- Details -->
            <div class="flex gap-8 justify-center text-gray-700 text-base mb-2">
                <p><span class="text-gray-500 italic">Thời gian:</span> <strong>{{ $event->start_time->format('d/m/Y') }}</strong></p>
                <p><span class="text-gray-500 italic">Vai trò:</span> <strong>{{ $registration->role ?? 'Tình nguyện viên' }}</strong></p>
                <p><span class="text-gray-500 italic">Đánh giá:</span> <strong class="text-green-700">Hoàn thành tốt</strong></p>
            </div>

            <!-- Footer / Signatures -->
            <div class="w-full flex justify-between items-end mt-4 px-8 pb-4">
                <!-- QR & Code (Left) -->
                <div class="text-center w-1/3">
                    <div class="mb-3 flex justify-center">
                         <div class="bg-white p-1 border border-gray-200 shadow-sm inline-block">
                             <!-- QR Code Placeholder -->
                             <div class="w-20 h-20 bg-gray-900 flex items-center justify-center text-white text-[8px]">QR CODE</div>
                         </div>
                    </div>
                    <p class="text-xs text-gray-500 font-mono">CODE: <span class="font-bold text-gray-800">{{ $certificate->code ?? 'CERT-000' }}</span></p>
                    <p class="text-xs text-gray-500 italic">Hà Nội, ngày {{ \Carbon\Carbon::parse($certificate->issued_at)->day }} tháng {{ \Carbon\Carbon::parse($certificate->issued_at)->month }} năm {{ \Carbon\Carbon::parse($certificate->issued_at)->year }}</p>
                </div>

                <!-- Signature (Right) -->
                <div class="text-center w-1/3 relative">
                    <p class="uppercase font-bold text-gray-800 text-sm mb-1">TM. Ban Chấp Hành Đoàn Trường</p>
                    <p class="italic text-xs text-gray-500 mb-16">(Ký và đóng dấu)</p>
                    
                    <!-- Seal and Signature -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                         <div class="relative w-32 h-32">
                             <!-- Signature -->
                             <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -rotate-12 z-20">
                                 <span class="font-script text-3xl text-blue-800 opacity-90">NguyenVanA</span>
                             </div>
                             
                             <!-- Seal -->
                            <div class="w-28 h-28 rounded-full border-4 border-red-600 text-red-600 flex items-center justify-center p-1 absolute top-0 left-2 opacity-70 rotate-[-15deg] z-10 mix-blend-multiply">
                                <div class="w-full h-full rounded-full border-2 border-red-600 flex items-center justify-center text-center text-[9px] font-black uppercase leading-tight tracking-tighter">
                                    Đoàn TNCS HCM<br>Học viện PNVN<br>★<br>BCH ĐOÀN
                                </div>
                            </div>
                         </div>
                    </div>

                    <p class="font-bold text-gray-800 text-base relative z-30 mt-2">Nguyễn Văn A</p>
                    <p class="text-xs uppercase text-gray-500 font-bold tracking-wider">Bí Thư Đoàn Trường</p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
