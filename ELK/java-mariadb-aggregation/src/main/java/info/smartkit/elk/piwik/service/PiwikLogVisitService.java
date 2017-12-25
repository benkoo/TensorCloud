package info.smartkit.elk.piwik.service;

import com.google.common.collect.Lists;

import info.smartkit.elk.piwik.dao.PiwikLogVisitDAO;
import info.smartkit.elk.piwik.domain.PiwikLogVisit;
import info.smartkit.elk.exception.ResourceNotFoundException;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.support.rowset.SqlRowSet;
import org.springframework.stereotype.Service;


import java.sql.SQLException;
import java.util.Collection;

@Service
public class PiwikLogVisitService {

    @Autowired
    private PiwikLogVisitDAO piwikLogVisitDAO;

    private static final Logger LOGGER = LoggerFactory.getLogger(PiwikLogVisitService.class);


    private  static final String SQL_piwik_log_visit = "select idsite,idvisit,\n" +
            "visitor_localtime,\n" +
            "visitor_returning,\n" +
            "visitor_count_visits,\n" +
            "visitor_days_since_last,\n" +
            "visitor_days_since_order,\n" +
            "visitor_days_since_first,\n" +
            "visit_first_action_time,\n" +
            "visit_last_action_time,\n" +
            "visit_exit_idaction_url,\n" +
            "visit_exit_idaction_name,\n" +
            "visit_entry_idaction_url,\n" +
            "visit_entry_idaction_name,\n" +
            "visit_total_actions,\n" +
            "visit_total_searches,\n" +
            "visit_total_events,\n" +
            "visit_total_time,\n" +
            "visit_goal_converted,\n" +
            "visit_goal_buyer,\n" +
            "referer_type,\n" +
            "referer_name,\n" +
            "referer_url,\n" +
            "referer_keyword,\n" +
            "config_id,\n" +
            "config_os,\n" +
            "config_browser_name,\n" +
            "config_browser_version,\n" +
            "config_resolution,\n" +
            "config_pdf,\n" +
            "config_flash,\n" +
            "config_java,\n" +
            "config_director,\n" +
            "config_quicktime,\n" +
            "config_realplayer,\n" +
            "config_windowsmedia,\n" +
            "config_gears,\n" +
            "config_silverlight,\n" +
            "config_cookie,\n" +
            "inet_ntoa(conv(hex(location_ip), 16, 10)) as location_ip, \n" +
            "location_browser_lang,\n" +
            "location_country,\n" +
            "location_region,\n" +
            "location_city,\n" +
            "location_latitude,\n" +
            "location_longitude,\n" +
            "conv(hex(idvisitor), 16, 10) as idvisitor from piwik_log_visit;";
    @Autowired
    private JdbcTemplate jdbcTemplate;

    public JSONArray getAllPiwikLogVisitsRaw() throws SQLException {
        //@see:https://piwik.org/faq/how-to/#faq_158
//        String sql = "select idsite,idvisit,visit_last_action_time,user_id,inet_ntoa(conv(hex(location_ip), 16, 10)) as location_ip, conv(hex(idvisitor), 16, 10) as idvisitor from piwik_log_visit";
        SqlRowSet rows = jdbcTemplate.queryForRowSet(SQL_piwik_log_visit);
//        List<Object> ObjlistAll = new ArrayList<Object>();
        //
        JSONArray jsonArray = new JSONArray();
        while (rows.next()) {
            //
            int colCount = rows.getMetaData().getColumnCount();
//            List<Object> Objlist = new ArrayList<Object>();
            JSONObject jsonObject = new JSONObject();
            for (int i = 1; i <= colCount; i++) {
//                Objlist.add(rows.getObject(i));
                String column_name = rows.getMetaData().getColumnName(i);
                jsonObject.put(column_name, rows.getObject(column_name));
            }
            LOGGER.info(jsonObject.toJSONString());
            jsonArray.add(jsonObject);
//            ObjlistAll.add(Objlist);
        }

        return jsonArray;
    }

    /**
     * Allows to retrieve all existing users from the database.
     * Pagination is not implemented in order to keep it simple.
     *
     * @return the all existing {@link PiwikLogVisit} entities
     */
    public Collection<PiwikLogVisit> getAllPiwikLogVisits() {
        System.out.println("system.out.println:"+this.piwikLogVisitDAO.findAll());
        return Lists.newArrayList(this.piwikLogVisitDAO.findAll());
    }

    /**
     * Allows to get a user by the given user identifier.
     *
     * @param piwikLogVisitId the piwikLogVisit id
     * @return the {@link PiwikLogVisit}
     */
    public PiwikLogVisit getPiwikLogVisit(final Long piwikLogVisitId) {
        return findPiwikLogVisitOrThrowNotFoundException(piwikLogVisitId);
    }

    private PiwikLogVisit findPiwikLogVisitOrThrowNotFoundException(final Long piwikLogVisitId) {
        PiwikLogVisit piwikLogVisit = this.piwikLogVisitDAO.findOne(piwikLogVisitId);
        if (piwikLogVisit == null) {
            throw new ResourceNotFoundException(String.format("PiwikLogVisit %s not found", piwikLogVisit));
        }
        return piwikLogVisit;
    }
    //Others,@see:https://developer.piwik.org/guides/persistence-and-the-mysql-backend



}
