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
                            view === "month" && date.toDateString() === today.toDateString()
                                ? "bg-custom-emerald text-white"
                                : null
                        }
                        activeStartDate={new Date(today.getFullYear(), today.getMonth(), 1)}
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
                        <div className="relative rounded-2xl transition duration-300 ease-in-out outline outline-custom-emerald">

                            {/* Judul Kegiatan */}
                            <div className="flex items-center gap-2 mb-6 bg-custom-emerald text-white rounded-t-xl p-4">
                                <p className="text-2xl lg:text-3xl font-extrabold">📅</p>
                                <div className="flex flex-col gap-1">
                                    <h3 className="text-2xl lg:text-3xl font-extrabold flex items-center gap-2">
                                        {getEvent(date).type}
                                    </h3>
                                    <p className="text-lg">
                                        {getEvent(date).start.toLocaleDateString("id-ID", {
                                            weekday: "long",
                                            year: "numeric",
                                            month: "long",
                                            day: "numeric",
                                        })}
                                    </p>
                                </div>
                            </div>

                            <div className="px-8 py-4 bg-white rounded-b-xl text-custom-emerald">

                                {/* Detail Waktu */}
                                <div className="grid grid-cols-2 gap-8 mb-8">
                                    <div className="text-center">
                                        <p className="font-bold text-2xl">Mulai</p>
                                        <p className="text-lg font-semibold">{getEvent(date).time_opened} WIB</p>
                                    </div>

                                    <div className="text-center">
                                        <p className="font-bold text-2xl">Selesai</p>
                                        <p className="text-lg font-semibold">{getEvent(date).time_closed} WIB</p>
                                    </div>
                                </div>

                                {/* Deskripsi */}
                                <div>
                                    <p className="font-bold text-2xl mb-2">Keterangan Acara:</p>
                                    <p className="text-base mb-2">{getEvent(date).description}</p>
                                </div>
                            </div>
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
