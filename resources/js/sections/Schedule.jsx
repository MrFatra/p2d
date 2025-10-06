import { usePage } from "@inertiajs/react";
import { useState, useMemo } from "react";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import { FaCalendarAlt } from "react-icons/fa";

const CalendarEventIcon = (props) => <FaCalendarAlt {...props} />;

export default function ImmunizationSchedule() {
    const { schedules } = usePage().props;
    const today = new Date();
    const [date, setDate] = useState(today);

    // 🔹 Mapping schedules dari Laravel ke events untuk kalender
    const events = useMemo(() => {
        return schedules.map((schedule) => {
            const [openHour, openMinute] = schedule.time_opened.split(':').map(Number);
            const [closeHour, closeMinute] = schedule.time_closed.split(':').map(Number);

            const startDateTime = new Date(schedule.date_open);
            startDateTime.setHours(openHour, openMinute);

            const endDateTime = new Date(schedule.date_closed);
            endDateTime.setHours(closeHour, closeMinute);

            const formatTime = (time) => time.split(':').slice(0, 2).join(':');

            return {
                id: schedule.id,
                type: schedule.type,
                description: schedule.notes ?? "Tidak ada deskripsi",
                start: startDateTime,
                end: endDateTime,
                time_opened: formatTime(schedule.time_opened),
                time_closed: formatTime(schedule.time_closed),
            };
        });
    }, [schedules]);

    // 🔹 Ambil event yang cocok dengan tanggal dipilih
    const getEvent = (selectedDate) => {
        return events.find(
            (event) => event.start.toDateString() === selectedDate.toDateString()
        );
    };

    return (
        <div id="schedule" className="container mx-auto py-20 max-w-7xl text-foreground">

            <div className="text-center">
                <h2 className="text-2xl md:text-3xl font-bold text-custom-emerald mb-2">
                    Jadwal Kegiatan Posyandu
                </h2>
                <p className="text-gray-500 max-w-xl mx-auto">
                    Dapatkan informasi terkini mengenai jadwal kegiatan Posyandu. Jangan lewatkan pelayanan kesehatan yang rutin dilaksanakan setiap bulannya.
                </p>
            </div>

            <div className="flex flex-col items-center md:flex-row gap-8 bg-white p-8 rounded-lg shadow-lg">
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
                        <div className="relative bg-gradient-to-br from-custom-emerald/90 to-custom-emerald/70 text-white p-8 rounded-2xl shadow-lg transform hover:scale-[1.02] transition duration-300 ease-in-out">

                            {/* Judul Kegiatan */}
                            <h3 className="text-[1.65rem] lg:text-3xl font-extrabold mb-4 flex items-center gap-2">
                                📅 {getEvent(date).type}
                            </h3>

                            {/* Detail Tanggal */}
                            <p className="mt-2 font-bold text-white text-lg">Tanggal Mulai:</p>
                            <p>
                                {getEvent(date).start.toLocaleDateString(
                                    "id-ID",
                                    {
                                        weekday: "long",
                                        year: "numeric",
                                        month: "long",
                                        day: "numeric",
                                    }
                                )}
                            </p>

                            {/* Detail Waktu */}
                            <p className="mt-2 font-bold text-white text-lg">Waktu Mulai:</p>
                            <p>
                                {getEvent(date).time_opened}
                            </p>

                            <p className="mt-2 font-bold text-white text-lg">Waktu Selesai:</p>
                            <p>
                                {getEvent(date).time_closed}
                            </p>

                            {/* Deskripsi */}
                            <p className="mt-2 font-bold text-white text-lg">Keterangan:</p>
                            <p className="text-white/90 leading-relaxed">
                                {getEvent(date).description}
                            </p>
                        </div>
                    ) : (
                        <div className="bg-gray-50 border border-gray-200 p-8 rounded-2xl shadow-sm text-center text-gray-500">
                            <FaCalendarAlt className="mx-auto text-gray-400 text-4xl mb-3" />
                            Tidak ada jadwal kegiatan pada tanggal ini.
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
