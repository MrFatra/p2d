import { useState } from "react";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import { FaCalendarAlt } from "react-icons/fa";

const CalendarEventIcon = (props) => <FaCalendarAlt {...props} />;

export default function ImmunizationSchedule() {
    const today = new Date();
    const [date, setDate] = useState(today);
    const [events] = useState([
        {
            date: new Date(2025, 1, 20),
            title: "💉 Imunisasi Anak",
            type: "Posyandu",
            description:
                "Imunisasi rutin untuk anak-anak usia 0-5 tahun. Dapatkan vaksinasi lengkap untuk melindungi buah hati Anda dari penyakit berbahaya.",
        },
        {
            date: new Date(2025, 1, 25),
            title: "🩸 Donor Darah",
            type: "Donor Darah",
            description:
                "Ayo berpartisipasi dalam kegiatan donor darah untuk membantu sesama. Setiap tetes darah Anda sangat berarti untuk menyelamatkan nyawa.",
        },
        {
            date: new Date(2025, 2, 10),
            title: "🤰 Pemeriksaan Kesehatan Ibu Hamil",
            type: "Kesehatan Ibu",
            description:
                "Pemeriksaan rutin untuk ibu hamil, termasuk USG, tes darah, dan konsultasi dengan dokter kandungan. Pastikan kesehatan ibu dan janin selalu terpantau.",
        },
        {
            date: new Date(2025, 2, 15),
            title: "🎤 Seminar Parenting",
            type: "Edukasi",
            description:
                "Seminar tentang pola asuh anak yang baik dan benar. Dapatkan tips dari ahli psikologi anak untuk mendukung tumbuh kembang buah hati Anda.",
        },
        {
            date: new Date(2025, 3, 5),
            title: "🧘‍♀️ Senam Ibu Hamil",
            type: "Olahraga",
            description:
                "Senam khusus untuk ibu hamil untuk menjaga kebugaran tubuh dan mempersiapkan persalinan. Dipandu oleh instruktur profesional.",
        },
    ]);

    const getEvent = (selectedDate) => {
        return events.find(
            (event) => event.date.toDateString() === selectedDate.toDateString()
        );
    };

    return (
        <div className="container mx-auto my-28 px-8 max-w-7xl text-foreground">
            <h2 className="text-custom-emerald text-2xl md:text-3xl font-bold mb-2 text-center">
                Jadwal Kegiatan Posyandu
            </h2>

            <div className="flex flex-col md:flex-row gap-8 bg-white p-8 rounded-lg shadow-lg">
                <div className="w-full lg:w-1/2">
                    <Calendar
                        onChange={(val) => setDate(val)}
                        value={date}
                        tileContent={({ date, view }) =>
                            view === "month" && getEvent(date) ? (
                                <div className="flex justify-center items-center mt-1">
                                    <CalendarEventIcon className="text-custom-emerald text-lg" />
                                </div>
                            ) : null
                        }
                        tileClassName={({ date, view }) =>
                            view === "month" &&
                            date.toDateString() === today.toDateString()
                                ? "bg-custom-emerald text-white"
                                : null
                        }
                        activeStartDate={
                            new Date(today.getFullYear(), today.getMonth(), 1)
                        }
                        minDetail="month"
                        maxDetail="month"
                        locale="id-ID"
                        prevLabel={null}
                        nextLabel={null}
                        className="rounded-xl border-none shadow-sm"
                    />
                </div>

                <div className="w-full lg:w-1/2 flex flex-col justify-center">
                    {getEvent(date) ? (
                        <div className="bg-custom-emerald/10 p-6 rounded-lg">
                            <h3 className="text-custom-emerald text-2xl font-bold mb-5">
                                {getEvent(date).title}
                            </h3>
                            <p className="mb-2">
                                <strong>Tanggal:</strong>{" "}
                                {getEvent(date).date.toLocaleDateString(
                                    "id-ID",
                                    {
                                        weekday: "long",
                                        year: "numeric",
                                        month: "long",
                                        day: "numeric",
                                    }
                                )}
                            </p>
                            <p className="mb-2">
                                <strong>Jenis Kegiatan:</strong>{" "}
                                {getEvent(date).type}
                            </p>
                            <p>
                                <strong>Deskripsi Kegiatan:</strong>{" "}
                                {getEvent(date).description}
                            </p>
                        </div>
                    ) : (
                        <div className="bg-gray-100 p-6 rounded-lg">
                            <p className="text-gray-500 text-center">
                                Tidak ada jadwal imunisasi atau kegiatan pada
                                tanggal ini.
                            </p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
